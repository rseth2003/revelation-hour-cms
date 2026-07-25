<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GivingMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class GivingMethodController extends Controller
{
    public function index(): View
    {
        $methods = GivingMethod::query()->orderBy('sort_order')->orderBy('id')->get();
        return view('admin.giving-methods.index', compact('methods'));
    }

    public function create(): View
    {
        return view('admin.giving-methods.create', ['method' => new GivingMethod()]);
    }

    public function store(Request $request): RedirectResponse
    {
        GivingMethod::create($this->validated($request));
        return redirect()->route('admin.giving-methods.index')->with('success', 'Giving method created.');
    }

    public function edit(GivingMethod $givingMethod): View
    {
        return view('admin.giving-methods.edit', ['method' => $givingMethod]);
    }

    public function update(Request $request, GivingMethod $givingMethod): RedirectResponse
    {
        $givingMethod->update($this->validated($request));
        return redirect()->route('admin.giving-methods.index')->with('success', 'Giving method updated.');
    }

    public function destroy(GivingMethod $givingMethod): RedirectResponse
    {
        $givingMethod->delete();
        return redirect()->route('admin.giving-methods.index')->with('success', 'Giving method deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'provider' => ['required', Rule::in(array_keys(GivingMethod::PROVIDERS))],
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

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        return $data;
    }
}
