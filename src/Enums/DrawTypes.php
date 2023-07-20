<?php

namespace Leaguefy\LeaguefyManager\Enums;

use Leaguefy\LeaguefyManager\Traits\EnumActions;

enum DrawTypes: string
{
    use EnumActions;

    case NEXT = 'NEXT';
    case ALL = 'ALL';
}
