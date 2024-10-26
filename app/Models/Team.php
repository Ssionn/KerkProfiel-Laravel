<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $fillable = ['name', 'leader_id'];

    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id');
    }
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function isLeader(User $user): bool
    {
        return $this->leader_id === $user->id || $user->hasRole('teamleader');
    }
}
