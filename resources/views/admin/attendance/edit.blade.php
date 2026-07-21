<x-admin-layout>
<div class="mb-8">
    <a href="{{ route('admin.attendance.show', ['attendance' => $attendance->id]) }}" class="text-sm font-semibold text-slate-500">← Attendance details</a>
    <h1 class="mt-3 text-3xl font-bold text-[#072f68]">Edit attendance</h1>
    <p class="mt-2 text-slate-600">Update the session details and member check-ins.</p>
</div>

<form method="POST" action="{{ route('admin.attendance.update', ['attendance' => $attendance->id]) }}">
    @csrf
    @method('PUT')
    @include('admin.attendance._form')
</form>
</x-admin-layout>
