<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $this->ensureSuperAdmin($request);
        $users = User::query()->orderByDesc('is_active')->orderBy('name')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create(Request $request): View
    {
        $this->ensureSuperAdmin($request);
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureSuperAdmin($request);
        $data = $this->validatedData($request);
        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = $request->boolean('is_active');
        $data['module_access'] = $this->moduleAccess($request, $data['role']);
        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'CMS user created successfully.');
    }

    public function edit(Request $request, User $user): View
    {
        $this->ensureSuperAdmin($request);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->ensureSuperAdmin($request);
        $data = $this->validatedData($request, $user);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['module_access'] = $this->moduleAccess($request, $data['role']);

        if ($user->is($request->user())) {
            if (! $data['is_active']) {
                return back()->withErrors(['is_active' => 'You cannot deactivate your own account.'])->withInput();
            }
            $data['role'] = 'super_admin';
            $data['module_access'] = ['*'];
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'CMS user updated successfully.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->ensureSuperAdmin($request);
        if ($user->is($request->user())) {
            return back()->withErrors(['user' => 'You cannot delete your own account.']);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'CMS user deleted.');
    }

    private function ensureSuperAdmin(Request $request): void
    {
        abort_unless($request->user()?->role === 'super_admin', 403, 'Only the Super Admin can manage CMS users and permissions.');
    }

    private function validatedData(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:180', Rule::unique('users', 'email')->ignore($user?->id)],
            'role' => ['required', Rule::in(array_keys(User::ROLES))],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
            'is_active' => ['nullable', 'boolean'],
            'all_modules' => ['nullable', 'boolean'],
            'modules' => ['nullable', 'array'],
            'modules.*' => [Rule::in(array_keys(User::MODULES))],
        ]);
    }

    private function moduleAccess(Request $request, string $role): array
    {
        if ($role === 'super_admin' || $request->boolean('all_modules')) {
            return ['*'];
        }

        return array_values(array_unique($request->input('modules', [])));
    }
}
