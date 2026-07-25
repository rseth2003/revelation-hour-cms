@csrf
<div class="space-y-5">
<div><label class="mb-2 block font-semibold">Name</label><input name="name" value="{{ old('name',$libraryCategory->name ?? '') }}" class="w-full rounded-xl border-slate-300" required>@error('name')<p class="text-red-600">{{ $message }}</p>@enderror</div>
<div><label class="mb-2 block font-semibold">Description</label><textarea name="description" rows="5" class="w-full rounded-xl border-slate-300">{{ old('description',$libraryCategory->description ?? '') }}</textarea></div>
<div><label class="mb-2 block font-semibold">Display order</label><input type="number" min="0" name="sort_order" value="{{ old('sort_order',$libraryCategory->sort_order ?? 0) }}" class="w-full rounded-xl border-slate-300"></div>
<label class="flex gap-3"><input type="checkbox" name="is_published" value="1" @checked(old('is_published',$libraryCategory->is_published ?? true))><span>Publish this category</span></label>
<div class="flex gap-3"><button class="rounded-xl bg-[#072f68] px-5 py-3 font-bold text-white">{{ $buttonText }}</button><a href="{{ route('admin.library-categories.index') }}" class="rounded-xl border px-5 py-3">Cancel</a></div>
</div>
