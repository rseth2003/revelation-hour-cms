@csrf
<div class="grid gap-6 lg:grid-cols-2">
<div class="space-y-5">
<div><label class="mb-2 block text-sm font-semibold text-slate-700">Public title</label><input name="title" value="{{ old('title',$method->title) }}" class="w-full rounded-xl border-slate-300" required>@error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
<div><label class="mb-2 block text-sm font-semibold text-slate-700">Payment method</label><select name="provider" class="w-full rounded-xl border-slate-300" required>@foreach(\App\Models\GivingMethod::PROVIDERS as $value=>$label)<option value="{{ $value }}" @selected(old('provider',$method->provider ?: 'mtn_momo')===$value)>{{ $label }}</option>@endforeach</select></div>
<div><label class="mb-2 block text-sm font-semibold text-slate-700">Account or registered name</label><input name="account_name" value="{{ old('account_name',$method->account_name) }}" class="w-full rounded-xl border-slate-300" placeholder="Revelation Hour Ministries International"></div>
<div><label class="mb-2 block text-sm font-semibold text-slate-700">Phone number or payment code</label><input name="account_number" value="{{ old('account_number',$method->account_number) }}" class="w-full rounded-xl border-slate-300" placeholder="Add the official number or code"></div>
<div><label class="mb-2 block text-sm font-semibold text-slate-700">Giving instructions</label><textarea name="instructions" rows="6" class="w-full rounded-xl border-slate-300" placeholder="Add clear payment instructions">{{ old('instructions',$method->instructions) }}</textarea></div>
</div>
<div class="space-y-5">
<div class="grid gap-4 sm:grid-cols-2"><div><label class="mb-2 block text-sm font-semibold text-slate-700">Optional button label</label><input name="button_label" value="{{ old('button_label',$method->button_label) }}" class="w-full rounded-xl border-slate-300" placeholder="Give now"></div><div><label class="mb-2 block text-sm font-semibold text-slate-700">Optional button URL</label><input type="url" name="button_url" value="{{ old('button_url',$method->button_url) }}" class="w-full rounded-xl border-slate-300" placeholder="https://..."></div></div>
<input type="hidden" name="bank_name" value=""><input type="hidden" name="branch_name" value=""><input type="hidden" name="swift_code" value="">
<div><label class="mb-2 block text-sm font-semibold text-slate-700">Display order</label><input type="number" min="0" name="sort_order" value="{{ old('sort_order',$method->sort_order ?? 0) }}" class="w-full rounded-xl border-slate-300"></div>
<label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4"><input name="is_featured" type="checkbox" value="1" @checked(old('is_featured',$method->is_featured))><span><strong class="block text-sm">Feature this method</strong><span class="text-xs text-slate-500">Featured methods appear first.</span></span></label>
<label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4"><input name="is_published" type="checkbox" value="1" @checked(old('is_published',$method->exists ? $method->is_published : true))><span><strong class="block text-sm">Publish on website</strong><span class="text-xs text-slate-500">Turn this off until the method is ready.</span></span></label>
</div>
</div>
<div class="mt-8 flex gap-3"><button class="rounded-xl bg-[#072f68] px-6 py-3 font-semibold text-white">{{ $buttonText }}</button><a href="{{ route('admin.giving-methods.index') }}" class="rounded-xl border border-slate-300 px-6 py-3 font-semibold text-slate-700">Cancel</a></div>
