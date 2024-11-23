<?php

namespace App\Models;

use App\Enums\SurveyStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model
{
    protected $fillable = [
        'name',
        'is_available_for_team',
        'team_id',
        'creator_id',
    ];

    protected $casts = [
        'status' => SurveyStatus::class,
        'is_available_for_team' => 'boolean',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
