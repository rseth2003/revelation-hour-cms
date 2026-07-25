<x-admin-layout title="Library Categories | RHMI CMS" heading="Library Categories">
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
<div><h2 class="text-2xl font-bold text-[#072f68]">Library Categories</h2><p class="mt-1 text-sm text-slate-600">Organize books and documents for easy browsing.</p></div>
<a href="{{ route('admin.library-categories.create') }}" class="rounded-xl bg-lime-500 px-5 py-3 font-bold text-[#072f68]">+ Add Category</a>
</div>
@if(session('success'))<div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>@endif
<div class="overflow-hidden rounded-2xl border bg-white shadow-sm">
<table class="min-w-full divide-y divide-slate-200"><thead class="bg-slate-50"><tr><th class="px-5 py-3 text-left">Category</th><th class="px-5 py-3">Resources</th><th class="px-5 py-3">Status</th><th class="px-5 py-3"></th></tr></thead>
<tbody class="divide-y">@forelse($categories as $category)<tr><td class="px-5 py-4"><strong class="text-[#072f68]">{{ $category->name }}</strong><p class="text-sm text-slate-500">{{ $category->description }}</p></td><td class="px-5 py-4 text-center">{{ $category->resources_count }}</td><td class="px-5 py-4 text-center">{{ $category->is_published ? 'Published' : 'Hidden' }}</td><td class="px-5 py-4"><div class="flex justify-end gap-2"><a href="{{ route('admin.library-categories.edit',$category) }}" class="rounded-lg border px-3 py-2">Edit</a><form method="POST" action="{{ route('admin.library-categories.destroy',$category) }}" onsubmit="return confirm('Delete this category?')">@csrf @method('DELETE')<button class="rounded-lg border border-red-200 px-3 py-2 text-red-700">Delete</button></form></div></td></tr>@empty<tr><td colspan="4" class="p-10 text-center text-slate-500">No library categories have been added.</td></tr>@endforelse</tbody></table>
</div><div class="mt-6">{{ $categories->links() }}</div>
</x-admin-layout>
