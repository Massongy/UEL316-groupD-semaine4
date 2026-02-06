<?php

namespace App\Enum;

enum StatutPost: string
{
    case BROUILLON = 'brouillon';
    case PUBLIE = 'publié';
    case ARCHIVE = 'archivé';
}