<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunicationTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommunicationTemplateController extends Controller
{
    public function index(): View
    {
        return view('admin.communication.templates', [
            'templates' => CommunicationTemplate::latest()->get()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        CommunicationTemplate::create($request->validate([
            'name'=>['required','string','max:120'],
            'channel'=>['required','in:email,sms,whatsapp'],
            'subject'=>['nullable','string','max:180'],
            'body'=>['required','string','max:5000'],
            'is_active'=>['nullable','boolean'],
        ]) + ['is_active'=>$request->boolean('is_active')]);

        return back()->with('success','Template created.');
    }

    public function destroy(CommunicationTemplate $template): RedirectResponse
    {
        $template->delete();
        return back()->with('success','Template deleted.');
    }
}
