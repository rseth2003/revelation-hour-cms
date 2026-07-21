@php
    $attendanceAvailable = \Illuminate\Support\Facades\Schema::hasTable('attendance_sessions');
    $attendanceSessions = $attendanceAvailable ? \Illuminate\Support\Facades\DB::table('attendance_sessions')->count() : 0;
    $attendanceTotal = $attendanceAvailable ? (int) \Illuminate\Support\Facades\DB::table('attendance_sessions')->sum('total_attendance') : 0;
    $attendanceThisMonth = $attendanceAvailable ? (int) \Illuminate\Support\Facades\DB::table('attendance_sessions')
        ->whereBetween('held_at', [now()->startOfMonth(), now()->endOfMonth()])
        ->sum('total_attendance') : 0;
    $attendanceAverage = $attendanceSessions > 0 ? round($attendanceTotal / $attendanceSessions) : 0;
@endphp

<section class="mt-8 rounded-2xl border bg-white p-6 shadow-sm">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-[#072f68]">Attendance overview</h2>
            <p class="mt-1 text-sm text-slate-500">Live figures from recorded services and events.</p>
        </div>
        <a href="{{ route('admin.attendance.index') }}" class="rounded-xl border px-4 py-2 text-sm font-semibold text-slate-700">View attendance</a>
    </div>
    <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach([
            ['Sessions',$attendanceSessions],
            ['Total Recorded',$attendanceTotal],
            ['This Month',$attendanceThisMonth],
            ['Average Session',$attendanceAverage],
        ] as [$label,$value])
            <div class="rounded-xl bg-slate-50 p-4">
                <p class="text-sm font-semibold text-slate-500">{{ $label }}</p>
                <p class="mt-2 text-2xl font-bold text-[#072f68]">{{ number_format($value) }}</p>
            </div>
        @endforeach
    </div>
</section>
