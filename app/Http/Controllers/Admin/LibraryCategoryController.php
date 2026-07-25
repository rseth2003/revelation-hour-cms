<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LibraryCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.library-categories.index', [
            'categories'=>LibraryCategory::withCount('resources')
                ->orderBy('sort_order')->orderBy('name')->paginate(20),
        ]);
    }

    public function create(): View { return view('admin.library-categories.create'); }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = LibraryCategory::uniqueSlug($data['name']);
        $data['is_published'] = $request->boolean('is_published');
        LibraryCategory::create($data);
        return redirect()->route('admin.library-categories.index')->with('success','Library category created.');
    }

    public function edit(LibraryCategory $libraryCategory): View
    {
        return view('admin.library-categories.edit', compact('libraryCategory'));
    }

    public function update(Request $request, LibraryCategory $libraryCategory): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = LibraryCategory::uniqueSlug($data['name'], $libraryCategory->id);
        $data['is_published'] = $request->boolean('is_published');
        $libraryCategory->update($data);
        return redirect()->route('admin.library-categories.index')->with('success','Library category updated.');
    }

    public function destroy(LibraryCategory $libraryCategory): RedirectResponse
    {
        $libraryCategory->delete();
        return back()->with('success','Library category deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'=>['required','string','max:120'],
            'description'=>['nullable','string','max:2000'],
            'sort_order'=>['nullable','integer','min:0','max:9999'],
            'is_published'=>['nullable','boolean'],
        ]);
    }
}
