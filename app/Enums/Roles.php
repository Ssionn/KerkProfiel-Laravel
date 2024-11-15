<?php

namespace App\Enums;

enum Roles: string
{
    case TEAMLEADER = 'teamleader';
    case MEMBER = 'member';
    case ADMIN = 'admin';

}
