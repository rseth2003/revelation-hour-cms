<x-admin-layout>
<div class="mb-8">
    <a href="{{ route('admin.attendance.index') }}" class="text-sm font-semibold text-slate-500">← Attendance Management</a>
    <h1 class="mt-3 text-3xl font-bold text-[#072f68]">Record attendance</h1>
    <p class="mt-2 text-slate-600">Create a service or event attendance session and mark members present.</p>
</div>

<form method="POST" action="{{ route('admin.attendance.store') }}">
    @csrf
    @include('admin.attendance._form')
</form>
</x-admin-layout>
