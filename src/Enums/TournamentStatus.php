<?php

namespace Leaguefy\LeaguefyManager\Enums;

use Leaguefy\LeaguefyManager\Traits\EnumActions;

enum TournamentStatus: string
{
    use EnumActions;

    case CREATED = 'CREATED';
    case STARTED = 'STARTED';
    case ENDED = 'ENDED';
}
