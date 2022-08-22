<?php

namespace App\Enums;

enum Users: string
{
    case ANON = 'anon';
    case ADMIN = 'admin';
    case USER = 'user';
}
