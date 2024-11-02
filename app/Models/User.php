<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'provider',
        'provider_id',
        'provider_token',
        'team_id',
        'role_id',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function associateTeamToUser(Team $team): bool
    {
        $this->team_id = $team->id;

        return $this->save();
    }

    public function associateRoleToUser(string $roleName): bool
    {
        $this->role_id = Role::where('name', $roleName)->pluck('id')->first();

        return $this->save();
    }

    public function guestify(): bool
    {
        $this->role_id = Role::where('name', 'guest')->pluck('id')->first();
        $this->team_id = null;

        return $this->save();
    }

    public function hasPermission($permission)
    {
        return $this->role->permissions->contains('permission_name', $permission);
    }
}
