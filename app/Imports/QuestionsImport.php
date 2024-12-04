<?php

namespace App\Imports;

use App\Models\Question;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class QuestionsImport implements ToCollection
{
    public function __construct(
        protected $surveyId,
    ) {
        $this->surveyId = $surveyId;
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            if ($row[2] === null || empty($row[2])) {
                continue;
            }

            Question::create([
                'left_statement' => (string) trim($row[0]),
                'right_statement' => (string) trim($row[4]),
                'left_personality' => $row[1],
                'right_personality' => $row[3],
                'personality' => null,
                'sequence' => (int) $row[2],
                'survey_id' => $this->surveyId,
            ]);
        }
    }

    public function startRow(): int
    {
        return 0;
    }
}
