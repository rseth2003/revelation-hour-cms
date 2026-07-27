<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GivingMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use RuntimeException;

class GivingMethodController extends Controller
{
    public function index(): View
    {
        $methods = GivingMethod::query()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.giving-methods.index', compact('methods'));
    }

    public function create(): View
    {
        return view('admin.giving-methods.create', ['method' => new GivingMethod()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('icon')) {
            $data['icon_path'] = $this->storeIcon($request->file('icon'));
        }

        GivingMethod::create($data);

        return redirect()->route('admin.giving-methods.index')
            ->with('success', 'Giving method created.');
    }

    public function edit(GivingMethod $givingMethod): View
    {
        return view('admin.giving-methods.edit', ['method' => $givingMethod]);
    }

    public function update(Request $request, GivingMethod $givingMethod): RedirectResponse
    {
        $data = $this->validated($request);
        $oldIcon = $givingMethod->icon_path;

        if ($request->boolean('remove_icon')) {
            $data['icon_path'] = null;
        }

        if ($request->hasFile('icon')) {
            $data['icon_path'] = $this->storeIcon($request->file('icon'));
        }

        $givingMethod->update($data);

        if ($oldIcon && $oldIcon !== $givingMethod->icon_path) {
            Storage::disk('public')->delete($oldIcon);
        }

        return redirect()->route('admin.giving-methods.index')
            ->with('success', 'Giving method updated.');
    }

    public function destroy(GivingMethod $givingMethod): RedirectResponse
    {
        if ($givingMethod->icon_path) {
            Storage::disk('public')->delete($givingMethod->icon_path);
        }

        $givingMethod->delete();

        return redirect()->route('admin.giving-methods.index')
            ->with('success', 'Giving method deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'provider' => ['required', Rule::in(array_keys(GivingMethod::PROVIDERS))],
            'icon' => ['nullable', 'file', 'max:2048', 'mimes:png,jpg,jpeg,webp,svg'],
            'remove_icon' => ['nullable', 'boolean'],
            'account_name' => ['nullable', 'string', 'max:160'],
            'account_number' => ['nullable', 'string', 'max:100'],
            'bank_name' => ['nullable', 'string', 'max:160'],
            'branch_name' => ['nullable', 'string', 'max:160'],
            'swift_code' => ['nullable', 'string', 'max:80'],
            'instructions' => ['nullable', 'string', 'max:4000'],
            'button_label' => ['nullable', 'string', 'max:80'],
            'button_url' => ['nullable', 'url', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        unset($data['icon'], $data['remove_icon']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }

    private function storeIcon(UploadedFile $file): string
    {
        if (strtolower($file->getClientOriginalExtension()) === 'svg') {
            return $this->storeSanitizedSvg($file);
        }

        return $file->store('giving-methods', 'public');
    }

    private function storeSanitizedSvg(UploadedFile $file): string
    {
        $svg = file_get_contents($file->getRealPath());

        if ($svg === false || !preg_match('/<svg\b/i', $svg)) {
            throw new RuntimeException('The uploaded SVG is invalid.');
        }

        $svg = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $svg);
        $svg = preg_replace('/\son[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $svg);
        $svg = preg_replace('/(?:javascript|data):/i', '', $svg);
        $svg = preg_replace('/<foreignObject\b[^>]*>.*?<\/foreignObject>/is', '', $svg);

        $filename = 'giving-methods/'.bin2hex(random_bytes(20)).'.svg';
        Storage::disk('public')->put($filename, $svg);

        return $filename;
    }
}
