<?php

namespace App\Http\Controllers;

use App\Models\PrayerRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PrayerRequestController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:50'],
            'category' => ['required', 'in:'.implode(',', PrayerRequest::CATEGORIES)],
            'request_text' => ['required', 'string', 'max:8000'],
            'is_anonymous' => ['nullable', 'boolean'],
            'allow_follow_up' => ['nullable', 'boolean'],
        ]);

        $data['is_anonymous'] = $request->boolean('is_anonymous');
        $data['allow_follow_up'] = $request->boolean('allow_follow_up');
        $data['status'] = 'new';

        if ($data['is_anonymous']) {
            $data['name'] = null;
        }

        PrayerRequest::create($data);

        return redirect()
            ->route('contact')
            ->with('prayer_success', 'Your prayer request has been received. Our prayer team will stand with you in prayer.');
    }
}
