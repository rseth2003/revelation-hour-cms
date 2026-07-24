<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EventRegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $events = Event::query()
            ->withCount('registrations')
            ->when(
                $request->filled('search'),
                fn ($query) => $query->where(
                    'title',
                    'like',
                    '%'.$request->string('search')->trim().'%'
                )
            )
            ->orderByDesc('event_date')
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.event-registrations.index', compact('events'));
    }

    public function show(Request $request, Event $event): View
    {
        $registrations = $this->filteredRegistrations($request, $event)
            ->latest()
            ->paginate(25)
            ->withQueryString();

        $summary = [
            'total' => $event->registrations()->count(),
            'pending' => $event->registrations()->where('status', 'pending')->count(),
            'confirmed' => $event->registrations()->where('status', 'confirmed')->count(),
            'checked_in' => $event->registrations()->whereNotNull('checked_in_at')->count(),
            'cancelled' => $event->registrations()->where('status', 'cancelled')->count(),
        ];

        return view('admin.event-registrations.show', compact(
            'event',
            'registrations',
            'summary'
        ));
    }

    public function details(
        Event $event,
        EventRegistration $registration
    ): View {
        $this->ensureRegistrationBelongsToEvent($event, $registration);

        $registration->load(['member', 'campus']);

        return view('admin.event-registrations.details', compact(
            'event',
            'registration'
        ));
    }

    public function export(Request $request, Event $event): StreamedResponse
    {
        $filename = Str::slug($event->title).'-registrations-'.now()->format('Y-m-d-His').'.csv';

        $registrations = $this->filteredRegistrations($request, $event)
            ->oldest()
            ->get();

        return response()->streamDownload(function () use ($registrations, $event) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM for Excel compatibility.
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Event',
                'Full Name',
                'Phone',
                'Email',
                'Type',
                'Campus',
                'Status',
                'Checked In',
                'Check-in Time',
                'Registered At',
                'Notes',
            ]);

            foreach ($registrations as $registration) {
                fputcsv($handle, [
                    $event->title,
                    $registration->full_name,
                    $registration->phone,
                    $registration->email,
                    ucfirst($registration->registration_type),
                    $registration->campus?->name,
                    ucfirst($registration->status),
                    $registration->checked_in_at ? 'Yes' : 'No',
                    $registration->checked_in_at?->format('Y-m-d H:i:s'),
                    $registration->created_at?->format('Y-m-d H:i:s'),
                    $registration->notes,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function updateStatus(
        Request $request,
        Event $event,
        EventRegistration $registration
    ): RedirectResponse {
        $this->ensureRegistrationBelongsToEvent($event, $registration);

        $data = $request->validate([
            'status' => [
                'required',
                Rule::in(array_keys(EventRegistration::STATUSES)),
            ],
        ]);

        $updates = ['status' => $data['status']];

        if ($data['status'] !== 'confirmed') {
            $updates['checked_in_at'] = null;
        }

        $registration->update($updates);

        return back()->with(
            'success',
            'Registration for '.$registration->full_name.' marked as '.
            strtolower(EventRegistration::STATUSES[$data['status']]).'.'
        );
    }

    public function checkIn(
        Event $event,
        EventRegistration $registration
    ): RedirectResponse {
        $this->ensureRegistrationBelongsToEvent($event, $registration);

        if ($registration->status !== 'confirmed') {
            return back()->withErrors([
                'check_in' => 'Only confirmed registrations can be checked in.',
            ]);
        }

        if (! $registration->checked_in_at) {
            $registration->update(['checked_in_at' => now()]);
        }

        return back()->with(
            'success',
            $registration->full_name.' checked in successfully.'
        );
    }

    public function undoCheckIn(
        Event $event,
        EventRegistration $registration
    ): RedirectResponse {
        $this->ensureRegistrationBelongsToEvent($event, $registration);

        $registration->update(['checked_in_at' => null]);

        return back()->with(
            'success',
            'Check-in removed for '.$registration->full_name.'.'
        );
    }

    private function filteredRegistrations(Request $request, Event $event)
    {
        return $event->registrations()
            ->with(['member', 'campus'])
            ->when(
                $request->filled('status'),
                fn ($query) => $query->where('status', $request->string('status'))
            )
            ->when(
                $request->filled('type'),
                fn ($query) => $query->where('registration_type', $request->string('type'))
            )
            ->when($request->filled('check_in'), function ($query) use ($request) {
                match ($request->string('check_in')->toString()) {
                    'checked_in' => $query->whereNotNull('checked_in_at'),
                    'not_checked_in' => $query->whereNull('checked_in_at'),
                    default => null,
                };
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = '%'.$request->string('search')->trim().'%';

                $query->where(function ($query) use ($search) {
                    $query->where('full_name', 'like', $search)
                        ->orWhere('phone', 'like', $search)
                        ->orWhere('email', 'like', $search);
                });
            });
    }

    private function ensureRegistrationBelongsToEvent(
        Event $event,
        EventRegistration $registration
    ): void {
        abort_unless($registration->event_id === $event->id, 404);
    }
}
