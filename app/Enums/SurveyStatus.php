<?php

namespace App\Enums;

enum SurveyStatus
{
    case DRAFT;
    case PUBLISHED;
    case CLOSED;

    public static function valueOf(string $value): self
    {
        return match ($value) {
            'draft' => self::DRAFT,
            'published' => self::PUBLISHED,
            'closed' => self::CLOSED,
        };
    }
}
