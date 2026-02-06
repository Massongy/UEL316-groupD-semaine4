<?php

namespace App\Enum;

enum MotifSignalement: string
{
    case SPAM = 'spam';
    case LANGAGE_INAPPROPRIE = 'langage_inapproprié';
    case HARCELEMENT = 'harcèlement';
    case AUTRE = 'autre';
}