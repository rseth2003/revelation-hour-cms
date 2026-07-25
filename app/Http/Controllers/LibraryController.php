<?php
namespace App\Http\Controllers;

use App\Models\LibraryCategory;
use App\Models\LibraryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LibraryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = LibraryCategory::query()
            ->where('is_published', true)
            ->withCount(['resources' => fn ($query) => $query->where('is_published', true)])
            ->orderBy('sort_order')->orderBy('name')->get();

        $featured = LibraryResource::query()
            ->with('category')->where('is_published', true)->where('is_featured', true)
            ->orderBy('sort_order')->limit(4)->get();

        $resources = LibraryResource::query()
            ->with('category')->where('is_published', true)
            ->when($request->filled('category'), fn ($query) =>
                $query->whereHas('category', fn ($category) =>
                    $category->where('slug', $request->string('category'))))
            ->when($request->filled('type'), fn ($query) =>
                $query->where('resource_type', $request->string('type')))
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%'.$request->string('search')->trim().'%';
                $query->where(fn ($inner) => $inner
                    ->where('title','like',$term)
                    ->orWhere('author','like',$term)
                    ->orWhere('description','like',$term));
            })
            ->orderByDesc('is_featured')->orderBy('sort_order')->orderByDesc('published_at')
            ->paginate(12)->withQueryString();

        return view('pages.library.index', compact('categories','featured','resources'));
    }

    public function show(LibraryResource $resource): View
    {
        abort_unless($resource->is_published, 404);
        $resource->increment('view_count');
        $resource->load('category');

        $related = LibraryResource::query()
            ->where('is_published', true)->whereKeyNot($resource->id)
            ->when($resource->library_category_id, fn ($query) =>
                $query->where('library_category_id', $resource->library_category_id))
            ->limit(3)->get();

        return view('pages.library.show', compact('resource','related'));
    }

    public function read(LibraryResource $resource): BinaryFileResponse
    {
        abort_unless($resource->is_published && !$resource->is_paid
            && $resource->allow_read_online && $resource->file_path, 404);
        abort_unless(Storage::disk('public')->exists($resource->file_path), 404);

        return response()->file(Storage::disk('public')->path($resource->file_path), [
            'Content-Type'=>'application/pdf',
            'Content-Disposition'=>'inline; filename="'.basename($resource->file_path).'"',
        ]);
    }

    public function download(LibraryResource $resource): BinaryFileResponse
    {
        abort_unless($resource->is_published && !$resource->is_paid
            && $resource->allow_download && $resource->file_path, 404);
        abort_unless(Storage::disk('public')->exists($resource->file_path), 404);

        $resource->increment('download_count');
        return response()->download(Storage::disk('public')->path($resource->file_path));
    }
}
