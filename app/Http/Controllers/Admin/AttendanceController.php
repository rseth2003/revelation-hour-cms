<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\Campus;
use App\Models\ChurchService;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(): View
    {
        $services = ChurchService::query()
            ->with('campus')
            ->withCount([
                'attendanceRecords as present_count' => fn ($query) => $query->where('attendance_status', 'present'),
                'attendanceRecords as absent_count' => fn ($query) => $query->where('attendance_status', 'absent'),
            ])
            ->orderByDesc('service_date')
            ->orderByDesc('start_time')
            ->paginate(15);

        $stats = [
            'services' => ChurchService::count(),
            'this_month' => AttendanceRecord::where('attendance_status', 'present')
                ->whereMonth('checked_in_at', now()->month)
                ->whereYear('checked_in_at', now()->year)
                ->count(),
            'today' => AttendanceRecord::where('attendance_status', 'present')
                ->whereDate('checked_in_at', today())
                ->count(),
        ];

        return view('admin.attendance.index', compact('services', 'stats'));
    }

    public function create(): View
    {
        $campuses = Campus::query()
            ->orderByDesc('is_main_campus')
            ->orderBy('name')
            ->get();

        return view('admin.attendance.create', compact('campuses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'service_type' => ['required', 'in:'.implode(',', array_keys(ChurchService::TYPES))],
            'campus_id' => ['nullable', 'exists:campuses,id'],
            'service_date' => ['required', 'date_format:Y-m-d'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'status' => ['required', 'in:'.implode(',', array_keys(ChurchService::STATUSES))],
            'notes' => ['nullable', 'string', 'max:4000'],
        ]);

        $service = ChurchService::create($data);

        return redirect()
            ->route('admin.attendance.mark', $service)
            ->with('success', 'Service created. You can now mark attendance.');
    }

    public function mark(Request $request, ChurchService $service): View
    {
        $query = Member::query()
            ->with(['campus', 'ministry'])
            ->whereIn('membership_status', ['active', 'pending']);

        if ($service->campus_id) {
            $query->where(function ($subQuery) use ($service) {
                $subQuery
                    ->where('campus_id', $service->campus_id)
                    ->orWhereNull('campus_id');
            });
        }

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));

            $query->where(function ($subQuery) use ($search) {
                $subQuery
                    ->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('other_names', 'like', '%'.$search.'%')
                    ->orWhere('member_number', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%');
            });
        }

        $members = $query->orderBy('first_name')->orderBy('last_name')->paginate(40)->withQueryString();

        $existing = AttendanceRecord::query()
            ->where('church_service_id', $service->id)
            ->get()
            ->keyBy('member_id');

        $service->load('campus');

        return view('admin.attendance.mark', compact('service', 'members', 'existing'));
    }

    public function save(Request $request, ChurchService $service): RedirectResponse
    {
        $data = $request->validate([
            'attendance' => ['nullable', 'array'],
            'attendance.*' => ['in:present,absent,excused'],
        ]);

        $attendance = $data['attendance'] ?? [];

        DB::transaction(function () use ($attendance, $service, $request) {
            foreach ($attendance as $memberId => $status) {
                AttendanceRecord::updateOrCreate(
                    [
                        'church_service_id' => $service->id,
                        'member_id' => (int) $memberId,
                    ],
                    [
                        'attendance_status' => $status,
                        'checked_in_at' => now(),
                        'recorded_by' => $request->user()->id,
                    ]
                );
            }
        });

        return redirect()
            ->route('admin.attendance.mark', $service)
            ->with('success', 'Attendance saved successfully.');
    }

    public function show(ChurchService $service): View
    {
        $service->load('campus');

        $records = AttendanceRecord::query()
            ->with(['member.campus', 'recorder'])
            ->where('church_service_id', $service->id)
            ->orderBy('attendance_status')
            ->paginate(40);

        $counts = [
            'present' => AttendanceRecord::where('church_service_id', $service->id)->where('attendance_status', 'present')->count(),
            'absent' => AttendanceRecord::where('church_service_id', $service->id)->where('attendance_status', 'absent')->count(),
            'excused' => AttendanceRecord::where('church_service_id', $service->id)->where('attendance_status', 'excused')->count(),
        ];

        return view('admin.attendance.show', compact('service', 'records', 'counts'));
    }

    public function destroy(ChurchService $service): RedirectResponse
    {
        $service->delete();

        return redirect()
            ->route('admin.attendance.index')
            ->with('success', 'Service and its attendance records were deleted.');
    }
}
