<?php

namespace Leaguefy\LeaguefyManager\Observers;

use Leaguefy\LeaguefyManager\Models\Tournament;

class TournamentObserver
{
    /**
     * Handle the Tournament "created" event.
     */
    public function created(Tournament $tournament): void
    {
        $tournament->stages()->create();
    }
}
