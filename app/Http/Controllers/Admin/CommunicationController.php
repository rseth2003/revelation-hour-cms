<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\CommunicationMessage;
use App\Models\CommunicationRecipient;
use App\Models\CommunicationTemplate;
use App\Models\Member;
use App\Models\Ministry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommunicationController extends Controller
{
    public function index(): View
    {
        $messages = CommunicationMessage::latest()->paginate(15);
        $stats = [
            'drafts' => CommunicationMessage::where('status','draft')->count(),
            'scheduled' => CommunicationMessage::where('status','scheduled')->count(),
            'prepared' => CommunicationMessage::where('status','prepared')->count(),
            'recipients' => CommunicationRecipient::count(),
        ];

        return view('admin.communication.index', compact('messages','stats'));
    }

    public function create(): View
    {
        return view('admin.communication.create', [
            'campuses' => Campus::orderBy('name')->get(),
            'ministries' => Ministry::orderBy('name')->get(),
            'members' => Member::where('membership_status','active')->orderBy('first_name')->get(),
            'templates' => CommunicationTemplate::where('is_active',true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required','string','max:180'],
            'channel' => ['required','in:email,sms,whatsapp'],
            'subject' => ['nullable','string','max:180'],
            'body' => ['required','string','max:5000'],
            'audience_type' => ['required','in:all_members,campus,ministry,membership_type,membership_status,individual'],
            'campus_id' => ['nullable','exists:campuses,id'],
            'ministry_id' => ['nullable','exists:ministries,id'],
            'membership_type' => ['nullable','string'],
            'membership_status' => ['nullable','string'],
            'member_ids' => ['nullable','array'],
            'member_ids.*' => ['integer','exists:members,id'],
            'action' => ['required','in:draft,prepare,schedule'],
            'scheduled_for' => ['nullable','date','after:now'],
            'notes' => ['nullable','string','max:1500'],
        ]);

        $message = CommunicationMessage::create([
            ...$data,
            'created_by' => auth()->id(),
            'status' => $data['action'] === 'schedule' ? 'scheduled' : $data['action'],
            'scheduled_for' => $data['action'] === 'schedule' ? $data['scheduled_for'] : null,
        ]);

        if ($data['action'] !== 'draft') {
            $this->prepareRecipients($message);
        }

        return redirect()->route('admin.communication.show',$message)
            ->with('success','Communication saved successfully.');
    }

    public function show(CommunicationMessage $communication): View
    {
        $communication->load('recipients');
        return view('admin.communication.show', compact('communication'));
    }

    public function destroy(CommunicationMessage $communication): RedirectResponse
    {
        $communication->delete();
        return redirect()->route('admin.communication.index')->with('success','Communication deleted.');
    }

    private function prepareRecipients(CommunicationMessage $message): void
    {
        $query = Member::query()->where('membership_status','active');

        if ($message->channel === 'email') {
            $query->where('email_consent',true)->whereNotNull('email');
        } elseif ($message->channel === 'sms') {
            $query->where('sms_consent',true)->whereNotNull('phone');
        } else {
            $query->where('whatsapp_consent',true)->whereNotNull('phone');
        }

        match ($message->audience_type) {
            'campus' => $query->where('campus_id',$message->campus_id),
            'ministry' => $query->where('ministry_id',$message->ministry_id),
            'membership_type' => $query->where('membership_type',$message->membership_type),
            'membership_status' => $query->where('membership_status',$message->membership_status),
            'individual' => $query->whereIn('id',$message->member_ids ?? []),
            default => null,
        };

        $members = $query->get();

        foreach ($members as $member) {
            CommunicationRecipient::create([
                'communication_message_id' => $message->id,
                'member_id' => $member->id,
                'member_name' => $member->full_name,
                'destination' => $message->channel === 'email' ? $member->email : $member->phone,
                'status' => 'prepared',
            ]);
        }

        $message->update([
            'recipient_count' => $members->count(),
            'prepared_at' => now(),
            'status' => $message->status === 'scheduled' ? 'scheduled' : 'prepared',
        ]);
    }
}
