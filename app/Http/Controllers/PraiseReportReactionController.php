<?php

namespace App\Http\Controllers;

use App\Models\PraiseReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PraiseReportReactionController extends Controller
{
    public function store(Request $request, PraiseReport $praiseReport): RedirectResponse
    {
        abort_unless($praiseReport->status === 'published', 404);

        $data = $request->validate([
            'reaction' => ['required', Rule::in(['amen', 'praise_god', 'hallelujah', 'praying'])],
        ]);

        $ipHash = hash('sha256', (string) $request->ip().'|'.config('app.key'));

        $existing = $praiseReport->reactions()->where('ip_hash', $ipHash)->first();

        if ($existing) {
            $existing->update(['reaction' => $data['reaction']]);
            $message = 'Your reaction has been updated.';
        } else {
            $praiseReport->reactions()->create([
                'reaction' => $data['reaction'],
                'ip_hash' => $ipHash,
            ]);
            $message = 'Thank you for celebrating this praise report.';
        }

        return back()->with('success', $message);
    }
}
