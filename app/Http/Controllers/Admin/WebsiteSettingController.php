<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WebsiteSettingController extends Controller
{
    public function edit(): View
    {
        $settings = WebsiteSetting::current();

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $settings = WebsiteSetting::current();

        $data = $request->validate([
            'church_name' => ['required', 'string', 'max:180'],
            'short_name' => ['nullable', 'string', 'max:60'],
            'tagline' => ['nullable', 'string', 'max:180'],
            'address' => ['nullable', 'string', 'max:350'],
            'phone_primary' => ['nullable', 'string', 'max:60'],
            'phone_secondary' => ['nullable', 'string', 'max:60'],
            'email' => ['nullable', 'email', 'max:180'],
            'service_times' => ['nullable', 'string', 'max:3000'],
            'giving_details' => ['nullable', 'string', 'max:3000'],
            'footer_text' => ['nullable', 'string', 'max:500'],
            'facebook_url' => ['nullable', 'url', 'max:500'],
            'instagram_url' => ['nullable', 'url', 'max:500'],
            'youtube_url' => ['nullable', 'url', 'max:500'],
            'tiktok_url' => ['nullable', 'url', 'max:500'],
            'telegram_url' => ['nullable', 'url', 'max:500'],
            'whatsapp_url' => ['nullable', 'url', 'max:500'],
            'x_url' => ['nullable', 'url', 'max:500'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($request->hasFile('logo')) {
            if ($settings->logo_path) {
                Storage::disk('public')->delete($settings->logo_path);
            }

            $data['logo_path'] = $request->file('logo')->store('website', 'public');
        }

        $settings->update($data);

        return back()->with('success', 'Website settings updated successfully.');
    }
}
