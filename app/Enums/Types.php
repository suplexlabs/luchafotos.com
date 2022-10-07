<?php

namespace App\Enums;

enum Types: string
{
    case COMPANY = 'company';
    case EVENT = 'event';
    case WRESTLER = 'wrestler';
    case MATCH = 'match';
}
