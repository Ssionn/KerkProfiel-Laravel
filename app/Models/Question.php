<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'left_statement',
        'right_statement',
        'left_personality',
        'right_personality',
        'personality',
        'sequence',
        'survey_id',
    ];

    protected $casts = [
        'question' => 'json',
        'answered' => 'boolean',
    ];

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    // This returns an array with the values for the radio buttons (Eventually for calculation)
    public function radioButtonValues(): array
    {
        return [
            5,
            3,
            1,
            0,
            1,
            3,
            5,
        ];
    }

    public function calculateWeightedScore(int $answerValue): ?float
    {
        $weights = [
            0 => -2, // Strongly left
            1 => -1,
            2 => 0,  // Neutral
            3 => 1,
            4 => 2   // Strongly right
        ];

        return isset($weights[$answerValue]) ? $weights[$answerValue] : null;
    }
}
