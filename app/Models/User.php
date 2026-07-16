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

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }
}
