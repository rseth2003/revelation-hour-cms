<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'module_access',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'module_access' => 'array',
        ];
    }

    public const ROLES = [
        'super_admin' => 'Super Admin',
        'senior_pastor' => 'Senior Pastor',
        'campus_pastor' => 'Campus Pastor',
        'admin' => 'Administrator',
        'senior_usher' => 'Senior Usher',
        'membership_officer' => 'Membership Officer',
        'ministry_leader' => 'Ministry Leader',
        'media_team' => 'Media Team',
        'prayer_team' => 'Prayer Team',
    ];

    public const MODULES = [
        'website' => 'Website Settings & Pages',
        'media' => 'Hero Slider, Sermons, Gallery & Livestreams',
        'events' => 'Events & Event Registrations',
        'library' => 'eLibrary',
        'membership' => 'Members',
        'attendance' => 'Attendance',
        'church_structure' => 'Campuses, Ministries & Leadership',
        'prayer' => 'Prayer Requests',
        'giving' => 'Give & Donations',
        'communication' => 'Communication Center',
        'analytics' => 'Analytics & Reports',
        'users' => 'Users, Roles & Module Access',
    ];

    public const ROLE_DEFAULT_MODULES = [
        'senior_pastor' => ['website','media','events','library','membership','attendance','church_structure','prayer','giving','communication','analytics'],
        'campus_pastor' => ['events','membership','attendance','church_structure','prayer','communication','analytics'],
        'admin' => ['website','media','events','library','membership','attendance','church_structure','prayer','giving','communication','analytics'],
        'senior_usher' => ['membership','attendance'],
        'membership_officer' => ['membership','attendance','communication'],
        'ministry_leader' => ['events','church_structure','communication'],
        'media_team' => ['media','events','library'],
        'prayer_team' => ['prayer'],
    ];

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function hasAllModules(): bool
    {
        return $this->role === 'super_admin' || in_array('*', $this->module_access ?? [], true);
    }

    public function effectiveModules(): array
    {
        if ($this->hasAllModules()) {
            return array_keys(self::MODULES);
        }

        if (is_array($this->module_access)) {
            return array_values(array_intersect($this->module_access, array_keys(self::MODULES)));
        }

        return self::ROLE_DEFAULT_MODULES[$this->role] ?? [];
    }

    public function canAccessModule(string $module): bool
    {
        return $this->hasAllModules() || in_array($module, $this->effectiveModules(), true);
    }
}
