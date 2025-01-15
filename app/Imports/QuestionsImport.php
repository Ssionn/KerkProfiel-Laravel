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
                'left_statement' => $this->trimmedString($row[0]),
                'right_statement' => $this->trimmedString($row[4]),
                'left_personality' => $this->trimmedString($row[1]),
                'right_personality' => $this->trimmedString($row[3]),
                'sequence' => (int) $row[2],
                'survey_id' => $this->surveyId,
            ]);
        }
    }

    public function startRow(): int
    {
        return 0;
    }

    protected function trimmedString(string $string): string
    {
        return (string) trim($string);
    }
}
