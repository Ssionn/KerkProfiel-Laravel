<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Team extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'avatar',
        'owner_id',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'team_id');
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function surveys(): HasMany
    {
        return $this->hasMany(Survey::class);
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
        if (! $this->getFirstMediaUrl('team_avatars')) {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random&color=random?size=128';
        }

        $teamAvatar = $this->getMedia('team_avatars')->first();

        return $teamAvatar->getTemporaryUrl(
            Carbon::now()->addMinutes(5),
        );
    }

    public function createInvitationToken(): string
    {
        return bin2hex(random_bytes(24));
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(128)
              ->height(128)
              ->sharpen(10);
    }
}
