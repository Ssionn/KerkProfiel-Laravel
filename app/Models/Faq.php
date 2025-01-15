<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faq extends Model
{
    protected $fillable = [
        'question',
        'answer',
    ];

    public function role(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
