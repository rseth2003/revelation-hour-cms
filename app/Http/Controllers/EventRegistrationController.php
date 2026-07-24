<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Member;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventRegistrationController extends Controller
{
    public function create(Event $event): View
    {
        abort_unless($event->is_published, 404);

        $campuses = Campus::query()
            ->where('is_published', true)
            ->orderByDesc('is_main_campus')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('pages.event-registration.create', compact('event', 'campuses'));
    }

    public function store(Request $request, Event $event): RedirectResponse
    {
        abort_unless($event->is_published, 404);

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:180'],
            'phone' => ['required', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:255'],
            'registration_type' => ['required', 'in:member,visitor'],
            'campus_id' => ['nullable', 'exists:campuses,id'],
            'notes' => ['nullable', 'string', 'max:1500'],
        ]);

        $data['phone'] = trim($data['phone']);
        $data['email'] = filled($data['email'] ?? null)
            ? strtolower(trim($data['email']))
            : null;
        $data['event_id'] = $event->id;
        $data['status'] = 'pending';
        $data['member_id'] = $this->findMemberId($data['phone'], $data['email']);

        try {
            $registration = EventRegistration::create($data);
        } catch (QueryException $exception) {
            $message = strtolower($exception->getMessage());

            if (str_contains($message, 'unique') || str_contains($message, 'duplicate')) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'phone' => 'This phone number is already registered for this event.',
                    ]);
            }

            throw $exception;
        }

        return redirect()->route('event-registration.success', [
            'event' => $event,
            'registration' => $registration,
        ]);
    }

    public function success(Event $event, EventRegistration $registration): View
    {
        abort_unless(
            $event->is_published && $registration->event_id === $event->id,
            404
        );

        return view('pages.event-registration.success', compact('event', 'registration'));
    }

    private function findMemberId(string $phone, ?string $email): ?int
    {
        return Member::query()
            ->where(function ($query) use ($phone, $email) {
                $query->where('phone', $phone);

                if ($email) {
                    $query->orWhere('email', $email);
                }
            })
            ->value('id');
    }
}
