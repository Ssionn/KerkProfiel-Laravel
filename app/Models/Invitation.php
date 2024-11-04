<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invitation extends Model
{
    protected $fillable = [
        'email',
        'token',
        'team_id',
        'accepted_at',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
    ];

    public function team(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function invitedByTeam(int $teamId): bool
    {
        $this->team_id = $teamId;

        return $this->save();
    }
}
