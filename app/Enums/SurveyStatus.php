<?php

namespace App\Enums;

enum SurveyStatus: string
{
    case DRAFT = 'DRAFT';
    case PUBLISHED = 'PUBLISHED';
    case CLOSED = 'CLOSED';
}
