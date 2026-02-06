<?php

namespace App\Enum;

enum StatutCommentaire: string
{
    case VISIBLE = 'visible';
    case SIGNALE = 'signalé';
    case SUPPRIME = 'supprimé';
}