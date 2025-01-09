<?php

namespace App\Enums;

enum SurveyStatus: string
{
    case DRAFT = 'Concept';
    case PUBLISHED = 'Gepubliceerd';
    case CLOSED = 'Gesloten';

    public static function valueOf(string $value): string
    {
        return match ($value) {
            'Concept' => self::DRAFT->value,
            'Gepubliceerd' => self::PUBLISHED->value,
            'Gesloten' => self::CLOSED->value,
        };
    }
}
