<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Concerns\WithStartRow;

class QuestionsImport implements ToModel, WithStartRow, WithSkipDuplicates
{
    public function __construct(
        protected $surveyId,
    ) {
        $this->surveyId = $surveyId;
    }

    public function model(array $row): Question
    {
        $personalityMap = [
            'a' => 'evangelist',
            'p' => 'priest',
            'e' => 'teacher',
            'h' => 'parent',
            'l' => 'student'
        ];

        $personalityLeftSequence = $personalityMap[trim($row[1])];
        $personalityRightSequence = $personalityMap[trim($row[3])];

        return new Question([
            'left_statement' => $row[0],
            'right_statement' => $row[4],
            'left_personality' => $personalityLeftSequence,
            'right_personality' => $personalityRightSequence,
            'personality' => null,
            'sequence' => (int) trim($row[2]),
            'survey_id' => $this->surveyId,
        ]);
    }

    public function startRow(): int
    {
        return 3;
    }
}
