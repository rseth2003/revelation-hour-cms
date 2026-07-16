<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Member;
use App\Models\Ministry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $query = Member::query()->with(['campus', 'ministry'])->latest();

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));

            $query->where(function ($subQuery) use ($search) {
                $subQuery
                    ->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('other_names', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('member_number', 'like', '%'.$search.'%');
            });
        }

        if ($request->filled('membership_type')) {
            $query->where('membership_type', $request->input('membership_type'));
        }

        if ($request->filled('membership_status')) {
            $query->where('membership_status', $request->input('membership_status'));
        }

        if ($request->filled('campus_id')) {
            $query->where('campus_id', $request->integer('campus_id'));
        }

        $members = $query->paginate(20)->withQueryString();

        $counts = [
            'total' => Member::count(),
            'active' => Member::where('membership_status', 'active')->count(),
            'visitors' => Member::where('membership_type', 'visitor')->count(),
            'pending' => Member::where('membership_status', 'pending')->count(),
        ];

        return view('admin.members.index', compact('members', 'counts'));
    }

    public function create(): View
    {
        return view('admin.members.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['member_number'] = $this->nextMemberNumber();

        $this->applyCheckboxes($request, $data);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('members/photos', 'public');
        }

        $member = Member::create($data);

        return redirect()
            ->route('admin.members.show', $member)
            ->with('success', 'Member record created successfully.');
    }

    public function show(Member $member): View
    {
        $member->load(['campus', 'ministry']);

        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member): View
    {
        return view('admin.members.edit', array_merge(
            ['member' => $member],
            $this->formData()
        ));
    }

    public function update(Request $request, Member $member): RedirectResponse
    {
        $data = $this->validatedData($request);
        $this->applyCheckboxes($request, $data);

        if ($request->hasFile('photo')) {
            if ($member->photo_path) {
                Storage::disk('public')->delete($member->photo_path);
            }

            $data['photo_path'] = $request->file('photo')->store('members/photos', 'public');
        }

        $member->update($data);

        return redirect()
            ->route('admin.members.show', $member)
            ->with('success', 'Member record updated successfully.');
    }

    public function destroy(Member $member): RedirectResponse
    {
        if ($member->photo_path) {
            Storage::disk('public')->delete($member->photo_path);
        }

        $member->delete();

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Member record deleted.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'other_names' => ['nullable', 'string', 'max:150'],
            'gender' => ['nullable', 'in:Male,Female,Other,Prefer not to say'],
            'date_of_birth' => ['nullable', 'date_format:Y-m-d'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:180'],
            'address' => ['nullable', 'string', 'max:350'],
            'home_area' => ['nullable', 'string', 'max:150'],
            'occupation' => ['nullable', 'string', 'max:150'],
            'marital_status' => ['nullable', 'in:Single,Married,Divorced,Widowed,Separated,Prefer not to say'],
            'emergency_contact_name' => ['nullable', 'string', 'max:150'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:50'],
            'campus_id' => ['nullable', 'exists:campuses,id'],
            'ministry_id' => ['nullable', 'exists:ministries,id'],
            'membership_type' => ['required', 'in:'.implode(',', array_keys(Member::MEMBERSHIP_TYPES))],
            'membership_status' => ['required', 'in:'.implode(',', array_keys(Member::STATUSES))],
            'first_visit_date' => ['nullable', 'date_format:Y-m-d'],
            'joined_date' => ['nullable', 'date_format:Y-m-d'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'notes' => ['nullable', 'string', 'max:8000'],
            'is_baptized' => ['nullable', 'boolean'],
            'is_born_again' => ['nullable', 'boolean'],
            'sms_consent' => ['nullable', 'boolean'],
            'email_consent' => ['nullable', 'boolean'],
            'whatsapp_consent' => ['nullable', 'boolean'],
            'birthday_message_consent' => ['nullable', 'boolean'],
        ]);
    }

    private function applyCheckboxes(Request $request, array &$data): void
    {
        foreach ([
            'is_baptized',
            'is_born_again',
            'sms_consent',
            'email_consent',
            'whatsapp_consent',
            'birthday_message_consent',
        ] as $field) {
            $data[$field] = $request->boolean($field);
        }
    }

    private function formData(): array
    {
        return [
            'campuses' => Campus::query()->orderByDesc('is_main_campus')->orderBy('name')->get(),
            'ministries' => Ministry::query()->orderBy('name')->get(),
        ];
    }

    private function nextMemberNumber(): string
    {
        $next = (int) Member::max('id') + 1;

        return 'RHMI-'.str_pad((string) $next, 5, '0', STR_PAD_LEFT);
    }
}
