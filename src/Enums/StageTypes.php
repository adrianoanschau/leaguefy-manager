<?php

namespace Leaguefy\LeaguefyManager\Enums;

use Leaguefy\LeaguefyManager\Traits\EnumActions;

enum StageTypes: string
{
    use EnumActions;

    case SINGLE = 'SINGLE';
    case MULTIPLE = 'MULTIPLE';
    case ELIMINATION = 'ELIMINATION';
    case FINAL = 'FINAL';

    public static function isGroups($value)
    {
        return $value === static::SINGLE() || $value === static::MULTIPLE();
    }
}
