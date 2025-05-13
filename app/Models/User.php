<?php

namespace App\Models;

use Filament\Panel;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'ADMIN';
    const ROLE_STAFF = 'STAFF';
    const ROLE_MEMBER = 'MEMBER';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'middle_name',
        'photo',
        'address',
        'phone_number',
        'email',
        'birth_date',
        'password',
        'role',
        'weight',
        'weight_unit',
        'height',
        'height_unit',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === self::ROLE_ADMIN || $this->role === self::ROLE_STAFF;
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function memberships()
    {
        return $this->hasMany(UserMembership::class);
    }

    /**
     * Check if the user has an active membership.
     *
     * @param int $membershipId
     * @return bool
     */
    public function hasMembership($membershipId)
    {
        return $this->memberships()
            ->where('membership_id', $membershipId)
            ->exists();
    }

    public function hasActiveMembership()
    {
        $today = Carbon::today();

        return $this->memberships()
            ->where('is_active', true)
            ->where('status', 'APPROVED')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->exists();
    }

    public function hasPendingMembership()
    {
        return $this->memberships()
            ->where('status', 'PENDING')
            ->exists();
    }

    public function hasExpiredMembership()
    {
        $today = Carbon::today();

        return $this->memberships()
            ->where('is_active', true)
            ->where('status', 'APPROVED')
            ->whereDate('end_date', '<', $today)
            ->exists();
    }

    public function hasUpcomingApprovedMembership()
    {
        $today = now()->toDateString();

        return $this->memberships()
            ->where('status', 'APPROVED')
            ->where('is_active', true)
            ->whereDate('start_date', '>', $today)
            ->exists();
    }

    public function latestMembership()
    {
        return $this->memberships()
            ->with('membership')
            ->whereIn('status', ['APPROVED', 'PENDING'])
            ->orderByDesc('start_date')
            ->first();
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : asset('img/profile.jpg');
    }

    public function getActiveMembership()
    {
        $today = Carbon::today();

        return $this->memberships()
            ->where('is_active', true)
            ->where('status', 'APPROVED')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->first();
    }

    public function activeMembership()
    {
        $today = now();

        return $this->memberships()
            ->where('is_active', true)
            ->where('status', 'APPROVED')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->first();
    }
}
