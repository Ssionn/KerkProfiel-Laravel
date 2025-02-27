<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'provider',
        'provider_id',
        'provider_token',
        'avatar',
        'role_id',
        'team_id',
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

    public function surveys(): HasMany
    {
        return $this->hasMany(Survey::class);
    }

    public function associateTeamToUserByModel(Team $team): bool
    {
        $this->team_id = $team->id;

        return $this->save();
    }

    public function associateTeamToUserByTeamId(int $teamId): bool
    {
        $this->team_id = $teamId;

        return $this->save();
    }

    public function associateRoleToUser(string $roleName): bool
    {
        $this->role_id = Role::where('name', $roleName)->pluck('id')->first();

        return $this->save();
    }

    /*
    * Defaults to name column.
    */
    public function guestify(string $column = 'name', $columnDef = 'guest', ?User $user = null): bool
    {
        if (! Role::where($column, $columnDef)->exists()) {
            throw new Exception('Unable to update user role.');
        }

        $roleId = Role::where($column, $columnDef)->pluck('id')->first();

        if (!$roleId) {
            throw new Exception('Role ID could not be determined.');
        }

        if ($user === null) {
            $this->role_id = $roleId;
            return true;
        }

        $user->update([
            'role_id' => $roleId
        ]);

        return true;
    }

    public function hasPermission($permission)
    {
        return $this->role->permissions->contains('permission_name', $permission);
    }

    public function defaultUserAvatar(): string
    {
        if (! $this->avatar) {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->username) . '&background=random&color=random?size=128';
        }

        return $this->getFirstMediaUrl('avatars');
    }
}
