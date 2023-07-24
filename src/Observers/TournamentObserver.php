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

    /**
     * Handle the Tournament "updated" event.
     */
    public function updated(Tournament $tournament): void
    {
        //
    }

    /**
     * Handle the Tournament "deleted" event.
     */
    public function deleted(Tournament $tournament): void
    {
        //
    }

    /**
     * Handle the Tournament "restored" event.
     */
    public function restored(Tournament $tournament): void
    {
        //
    }

    /**
     * Handle the Tournament "force deleted" event.
     */
    public function forceDeleted(Tournament $tournament): void
    {
        //
    }
}
