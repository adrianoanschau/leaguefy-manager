<?php

namespace Leaguefy\LeaguefyManager;

use Illuminate\Support\ServiceProvider;
use Leaguefy\LeaguefyManager\Models\Stage;
use Leaguefy\LeaguefyManager\Models\Tournament;
use Leaguefy\LeaguefyManager\Observers\StageObserver;
use Leaguefy\LeaguefyManager\Observers\TournamentObserver;

class LeaguefyManagerEventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Tournament::observe(TournamentObserver::class);
        Stage::observe(StageObserver::class);
    }
}
