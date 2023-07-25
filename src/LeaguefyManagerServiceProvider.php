<?php

namespace Leaguefy\LeaguefyManager;

use Illuminate\Support\ServiceProvider;
use Leaguefy\LeaguefyManager\Models\Tournament;
use Leaguefy\LeaguefyManager\Models\Stage;
use Leaguefy\LeaguefyManager\Observers\TournamentObserver;
use Leaguefy\LeaguefyManager\Observers\StageObserver;

class LeaguefyManagerServiceProvider extends ServiceProvider
{
    public function boot(LeaguefyManager $manager)
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config' => config_path()], 'leaguefy-manager');

            if ($manager->migrations) {
                $this->loadMigrationsFrom($manager->migrations);
            }
        }

        $this->app->booted(fn () => $manager->routes());

        Tournament::observe(TournamentObserver::class);
        Stage::observe(StageObserver::class);
    }
}
