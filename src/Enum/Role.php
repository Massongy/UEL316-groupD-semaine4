<?php

namespace App\Enum;

enum Role: string
{
    case ADMIN = 'admin';
    case MEMBRE = 'membre';
    case VISITEUR = 'visiteur';
}