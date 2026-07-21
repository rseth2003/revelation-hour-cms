<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\Campus;
use App\Models\Event;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $query = AttendanceSession::with(['campus', 'event'])
            ->latest('held_at');

        if ($request->filled('service_type')) {
            $query->where('service_type', $request->string('service_type'));
        }

        if ($request->filled('campus_id')) {
            $query->where('campus_id', $request->integer('campus_id'));
        }

        $sessions = $query->paginate(15)->withQueryString();

        $stats = [
            'sessions' => AttendanceSession::count(),
            'this_month' => AttendanceSession::whereBetween('held_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])->sum('total_attendance'),
            'members_present' => AttendanceSession::sum('registered_members_present'),
            'visitors' => AttendanceSession::selectRaw(
                'COALESCE(SUM(adult_visitors + youth_visitors + children_visitors), 0) as total'
            )->value('total') ?? 0,
        ];

        return view('admin.attendance.index', [
            'sessions' => $sessions,
            'stats' => $stats,
            'campuses' => Campus::orderBy('name')->get(),
            'serviceTypes' => AttendanceSession::SERVICE_TYPES,
        ]);
    }

    public function create(): View
    {
        return view('admin.attendance.create', [
            'campuses' => Campus::orderBy('name')->get(),
            'events' => Event::orderByDesc('event_date')->get(),
            'members' => Member::with(['campus', 'ministry'])
                ->where('membership_status', 'active')
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get(),
            'serviceTypes' => AttendanceSession::SERVICE_TYPES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        $session = DB::transaction(function () use ($data) {
            $memberIds = collect($data['member_ids'] ?? [])
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values();

            $visitorTotal = (int) $data['adult_visitors']
                + (int) $data['youth_visitors']
                + (int) $data['children_visitors'];

            $session = AttendanceSession::create([
                'created_by' => auth()->id(),
                'campus_id' => $data['campus_id'] ?? null,
                'event_id' => $data['event_id'] ?? null,
                'title' => $data['title'],
                'service_type' => $data['service_type'],
                'held_at' => $data['held_at'],
                'adult_visitors' => $data['adult_visitors'],
                'youth_visitors' => $data['youth_visitors'],
                'children_visitors' => $data['children_visitors'],
                'registered_members_present' => $memberIds->count(),
                'total_attendance' => $memberIds->count() + $visitorTotal,
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($memberIds as $memberId) {
                AttendanceRecord::create([
                    'attendance_session_id' => $session->id,
                    'member_id' => $memberId,
                    'status' => 'present',
                    'checked_in_at' => now(),
                ]);
            }

            return $session;
        });

        return redirect()
            ->route('admin.attendance.show', $session)
            ->with('success', 'Attendance session recorded successfully.');
    }

    public function show(AttendanceSession $attendance): View
    {
        $attendance->load([
            'campus',
            'event',
            'records.member.campus',
            'records.member.ministry',
        ]);

        return view('admin.attendance.show', compact('attendance'));
    }

    public function edit(AttendanceSession $attendance): View
    {
        $attendance->load('records');

        return view('admin.attendance.edit', [
            'attendance' => $attendance,
            'campuses' => Campus::orderBy('name')->get(),
            'events' => Event::orderByDesc('event_date')->get(),
            'members' => Member::with(['campus', 'ministry'])
                ->where('membership_status', 'active')
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get(),
            'selectedMemberIds' => $attendance->records->pluck('member_id')->all(),
            'serviceTypes' => AttendanceSession::SERVICE_TYPES,
        ]);
    }

    public function update(Request $request, AttendanceSession $attendance): RedirectResponse
    {
        $data = $this->validatedData($request);

        DB::transaction(function () use ($attendance, $data) {
            $memberIds = collect($data['member_ids'] ?? [])
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values();

            $visitorTotal = (int) $data['adult_visitors']
                + (int) $data['youth_visitors']
                + (int) $data['children_visitors'];

            $attendance->update([
                'campus_id' => $data['campus_id'] ?? null,
                'event_id' => $data['event_id'] ?? null,
                'title' => $data['title'],
                'service_type' => $data['service_type'],
                'held_at' => $data['held_at'],
                'adult_visitors' => $data['adult_visitors'],
                'youth_visitors' => $data['youth_visitors'],
                'children_visitors' => $data['children_visitors'],
                'registered_members_present' => $memberIds->count(),
                'total_attendance' => $memberIds->count() + $visitorTotal,
                'notes' => $data['notes'] ?? null,
            ]);

            $attendance->records()->delete();

            foreach ($memberIds as $memberId) {
                AttendanceRecord::create([
                    'attendance_session_id' => $attendance->id,
                    'member_id' => $memberId,
                    'status' => 'present',
                    'checked_in_at' => now(),
                ]);
            }
        });

        return redirect()
            ->route('admin.attendance.show', $attendance)
            ->with('success', 'Attendance session updated successfully.');
    }

    public function destroy(AttendanceSession $attendance): RedirectResponse
    {
        $attendance->delete();

        return redirect()
            ->route('admin.attendance.index')
            ->with('success', 'Attendance session deleted.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'service_type' => ['required', 'in:' . implode(',', array_keys(AttendanceSession::SERVICE_TYPES))],
            'held_at' => ['required', 'date'],
            'campus_id' => ['nullable', 'exists:campuses,id'],
            'event_id' => ['nullable', 'exists:events,id'],
            'adult_visitors' => ['required', 'integer', 'min:0', 'max:100000'],
            'youth_visitors' => ['required', 'integer', 'min:0', 'max:100000'],
            'children_visitors' => ['required', 'integer', 'min:0', 'max:100000'],
            'member_ids' => ['nullable', 'array'],
            'member_ids.*' => ['integer', 'exists:members,id'],
            'notes' => ['nullable', 'string', 'max:3000'],
        ]);
    }
}
