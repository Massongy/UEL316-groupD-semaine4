<?php

namespace App\Enum;

enum Role: string
{
    case ADMIN = 'ROLE_ADMIN';
    case MEMBRE = 'ROLE_USER';
}
