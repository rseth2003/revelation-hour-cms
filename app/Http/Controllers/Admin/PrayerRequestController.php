<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrayerRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrayerRequestController extends Controller
{
    public function index(Request $request): View
    {
        $query = PrayerRequest::query()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));

            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%')
                    ->orWhere('request_text', 'like', '%'.$search.'%');
            });
        }

        $requests = $query->paginate(15)->withQueryString();

        $counts = [
            'all' => PrayerRequest::count(),
            'new' => PrayerRequest::where('status', 'new')->count(),
            'in_progress' => PrayerRequest::where('status', 'in_progress')->count(),
            'prayed_for' => PrayerRequest::where('status', 'prayed_for')->count(),
            'closed' => PrayerRequest::where('status', 'closed')->count(),
        ];

        return view('admin.prayer-requests.index', compact('requests', 'counts'));
    }

    public function show(PrayerRequest $prayerRequest): View
    {
        return view('admin.prayer-requests.show', compact('prayerRequest'));
    }

    public function update(Request $request, PrayerRequest $prayerRequest): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:'.implode(',', array_keys(PrayerRequest::STATUSES))],
            'assigned_to' => ['nullable', 'string', 'max:150'],
            'internal_notes' => ['nullable', 'string', 'max:8000'],
        ]);

        $prayerRequest->update($data);

        return back()->with('success', 'Prayer request updated successfully.');
    }

    public function destroy(PrayerRequest $prayerRequest): RedirectResponse
    {
        $prayerRequest->delete();

        return redirect()
            ->route('admin.prayer-requests.index')
            ->with('success', 'Prayer request deleted.');
    }
}
