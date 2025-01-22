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
            'left' => $this->left_personality,
            5,
            3,
            1,
            0,
            1,
            3,
            5,
            'right' => $this->right_personality,
        ];
    }

    /**
     * Calculate the weighted personality score based on the answer value
     * @param int $answerValue The selected answer value (0-7)
     * @return float|null Returns the weighted score or null if invalid input
     */
    public function calculateWeightedScore(int $answerValue): ?float
    {
        $weights = [
            0 => -5, // Strongly left
            1 => -3,
            2 => -1,
            3 => 0,  // Neutral
            4 => 1,
            5 => 3,
            6 => 5   // Strongly right
        ];

        return isset($weights[$answerValue]) ? $weights[$answerValue] : null;
    }
}
