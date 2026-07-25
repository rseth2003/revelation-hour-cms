<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LibraryCategory;
use App\Models\LibraryResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LibraryResourceController extends Controller
{
    public function index(Request $request): View
    {
        $resources = LibraryResource::with('category')
            ->when($request->filled('search'), fn ($query) =>
                $query->where('title','like','%'.$request->string('search')->trim().'%'))
            ->when($request->filled('category'), fn ($query) =>
                $query->where('library_category_id',$request->integer('category')))
            ->orderByDesc('is_featured')->orderBy('sort_order')->orderByDesc('created_at')
            ->paginate(15)->withQueryString();

        return view('admin.library-resources.index', [
            'resources'=>$resources,
            'categories'=>LibraryCategory::orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.library-resources.create', [
            'categories'=>LibraryCategory::orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = LibraryResource::uniqueSlug($data['title']);
        $this->setFlags($request,$data);
        $this->storeFiles($request,$data);
        LibraryResource::create($data);
        return redirect()->route('admin.library-resources.index')->with('success','Library resource created.');
    }

    public function edit(LibraryResource $libraryResource): View
    {
        return view('admin.library-resources.edit', [
            'libraryResource'=>$libraryResource,
            'categories'=>LibraryCategory::orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, LibraryResource $libraryResource): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = LibraryResource::uniqueSlug($data['title'],$libraryResource->id);
        $this->setFlags($request,$data);
        $this->storeFiles($request,$data,$libraryResource);
        $libraryResource->update($data);
        return redirect()->route('admin.library-resources.index')->with('success','Library resource updated.');
    }

    public function destroy(LibraryResource $libraryResource): RedirectResponse
    {
        foreach (['cover_path','file_path'] as $field) {
            if ($libraryResource->{$field}) Storage::disk('public')->delete($libraryResource->{$field});
        }
        $libraryResource->delete();
        return back()->with('success','Library resource deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'library_category_id'=>['nullable','exists:library_categories,id'],
            'title'=>['required','string','max:180'],
            'author'=>['nullable','string','max:150'],
            'resource_type'=>['required','in:'.implode(',',array_keys(LibraryResource::TYPES))],
            'description'=>['nullable','string','max:10000'],
            'cover'=>['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'],
            'file'=>['nullable','file','mimes:pdf','max:102400'],
            'price_ugx'=>['nullable','integer','min:0','max:100000000'],
            'sort_order'=>['nullable','integer','min:0','max:9999'],
            'is_paid'=>['nullable','boolean'],
            'allow_read_online'=>['nullable','boolean'],
            'allow_download'=>['nullable','boolean'],
            'is_featured'=>['nullable','boolean'],
            'is_published'=>['nullable','boolean'],
        ]);
    }

    private function setFlags(Request $request,array &$data): void
    {
        foreach (['is_paid','allow_read_online','allow_download','is_featured','is_published'] as $flag) {
            $data[$flag] = $request->boolean($flag);
        }
        $data['price_ugx'] = $data['is_paid'] ? ($data['price_ugx'] ?? 0) : 0;
        $data['published_at'] = $data['is_published'] ? now() : null;
    }

    private function storeFiles(Request $request,array &$data,?LibraryResource $resource=null): void
    {
        foreach (['cover'=>['cover_path','library/covers'],'file'=>['file_path','library/files']] as $input=>[$field,$folder]) {
            if (!$request->hasFile($input)) continue;
            if ($resource?->{$field}) Storage::disk('public')->delete($resource->{$field});
            $data[$field] = $request->file($input)->store($folder,'public');
        }
    }
}
