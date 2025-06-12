<?php

namespace App\Models;

use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'ADMIN';
    const ROLE_STAFF = 'STAFF';
    const ROLE_MEMBER = 'MEMBER';

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === self::ROLE_ADMIN || $this->role === self::ROLE_STAFF;
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function memberships()
    {
        return $this->hasMany(UserMembership::class);
    }

    /**
     * Check if user has a specific membership (active or not)
     */
    public function hasMembership($membershipId = null)
    {
        if ($membershipId) {
            return $this->memberships()
                ->where('membership_id', $membershipId)
                ->exists();
        }
        return $this->memberships()->exists();
    }

    public function trainerStudents()
    {
        return $this->hasMany(\App\Models\TrainerStudent::class, 'user_id');
    }

    public function hasTrainer(int $trainerId): bool
    {
        return $this->trainerStudents()->where('trainer_id', $trainerId)->exists();
    }

    /**
     * Check if user has any active membership
     */
    public function hasActiveMembership($membershipId = null)
    {
        $today = Carbon::today();
        $query = $this->memberships()
            ->where('is_active', true)
            ->where('status', 'APPROVED')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today);

        if ($membershipId) {
            $query->where('membership_id', $membershipId);
        }

        return $query->exists();
    }

    /**
     * Get the current active membership
     */
    public function getActiveMembership()
    {
        $today = Carbon::today();
        return $this->memberships()
            ->with('membership')
            ->where('is_active', true)
            ->where('status', 'APPROVED')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->first();
    }

    /**
     * Check if user can upgrade to a specific membership
     * Based on membership level/rank or price
     */
    public function canUpgradeTo($membershipId)
    {
        $activeMembership = $this->getActiveMembership();

        // If no active membership, they can "upgrade" (which would be initial enrollment)
        if (!$activeMembership) {
            return true;
        }

        $targetMembership = Membership::find($membershipId);

        // If target membership doesn't exist, can't upgrade
        if (!$targetMembership) {
            return false;
        }

        // Compare based on your business logic - here using price as an example
        // You might want to use a 'level' or 'rank' field instead
        return $targetMembership->price > $activeMembership->membership->price;
    }

    /**
     * Get available upgrade options for the user
     */
    public function availableUpgrades()
    {
        $activeMembership = $this->getActiveMembership();

        if (!$activeMembership) {
            return Membership::all(); // All memberships available if no current one
        }

        return Membership::where('price', '>', $activeMembership->membership->price)
            ->orWhere('level', '>', $activeMembership->membership->level) // if you have a level field
            ->get();
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

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->first_name . ' ' . $this->last_name,
        );
    }
}
