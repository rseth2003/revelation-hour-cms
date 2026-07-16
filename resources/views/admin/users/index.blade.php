<x-admin-layout title="Users and Roles | RHMI CMS" heading="Users and Roles">
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-[#072f68]">CMS Users and Roles</h2>
        <p class="mt-1 text-sm text-slate-600">Control who can access the church management system.</p>
    </div>

    <a href="{{ route('admin.users.create') }}" class="rounded-xl bg-lime-500 px-5 py-3 font-bold text-[#072f68]">
        + Add CMS User
    </a>
</div>

@if(session('success'))
<div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800">
    @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
</div>
@endif

<div class="overflow-hidden rounded-2xl border bg-white shadow-sm">
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-slate-200">
<thead class="bg-slate-50">
<tr>
<th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">User</th>
<th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Role</th>
<th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Status</th>
<th class="px-5 py-4"></th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100">
@foreach($users as $user)
<tr>
<td class="px-5 py-4">
    <p class="font-semibold text-[#072f68]">{{ $user->name }}</p>
    <p class="text-sm text-slate-500">{{ $user->email }}</p>
</td>
<td class="px-5 py-4 text-sm text-slate-700">{{ \App\Models\User::ROLES[$user->role] ?? ucfirst(str_replace('_',' ',$user->role)) }}</td>
<td class="px-5 py-4">
    <span class="rounded-full px-3 py-1 text-xs font-bold {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
        {{ $user->is_active ? 'Active' : 'Inactive' }}
    </span>
</td>
<td class="px-5 py-4">
<div class="flex justify-end gap-2">
<a href="{{ route('admin.users.edit',$user) }}" class="rounded-lg border border-blue-200 px-4 py-2 text-sm font-semibold text-blue-700">Edit</a>
@if(!auth()->user()->is($user))
<form method="POST" action="{{ route('admin.users.destroy',$user) }}" onsubmit="return confirm('Delete this CMS user?')">
@csrf
@method('DELETE')
<button class="rounded-lg border border-red-200 px-4 py-2 text-sm font-semibold text-red-700">Delete</button>
</form>
@endif
</div>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>

<div class="mt-6">{{ $users->links() }}</div>
</x-admin-layout>
