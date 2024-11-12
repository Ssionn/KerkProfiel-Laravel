<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Team extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'avatar',
        'user_id',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'team_id');
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function defaultTeamAvatar(): string
    {
        if (! $this->avatar) {
            return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=random&color=random?size=128';
        }

        return $this->getFirstMediaUrl('avatars');
    }
}
