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

    public function getLeftStatementAttribute()
    {
        return $this->question['left_statement'] ?? null;
    }

    public function getRightStatementAttribute()
    {
        return $this->question['right_statement'] ?? null;
    }

    public function getSequenceNumberAttribute()
    {
        return $this->question['sequence_number'] ?? null;
    }

    public function getPersonalityLabelAttribute()
    {
        return [
            'evangelist' => 'Evangelist',
            'priest' => 'Priester',
            'teacher' => 'Leraar',
            'parent' => 'Ouder',
            'student' => 'Student'
        ][$this->personality] ?? 'Student';
    }

    public function scopeOrdered($query)
    {
        return $query->orderByRaw("CAST(JSON_EXTRACT(question, '$.sequence_number') AS UNSIGNED)");
    }
}
