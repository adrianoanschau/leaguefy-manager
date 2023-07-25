<?php

namespace Leaguefy\LeaguefyManager;

use Illuminate\Support\ServiceProvider;
use Leaguefy\LeaguefyManager\Models\Tournament;
use Leaguefy\LeaguefyManager\Models\Stage;
use Leaguefy\LeaguefyManager\Observers\TournamentObserver;
use Leaguefy\LeaguefyManager\Observers\StageObserver;
use Leaguefy\LeaguefyManager\Repositories\Contracts\RepositoryInterface;
use Leaguefy\LeaguefyManager\Repositories\GameRepository;
use Leaguefy\LeaguefyManager\Repositories\TeamRepository;
use Leaguefy\LeaguefyManager\Repositories\TournamentRepository;
use Leaguefy\LeaguefyManager\Repositories\StageRepository;

class LeaguefyManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, GameRepository::class);
        $this->app->bind(RepositoryInterface::class, TeamRepository::class);
        $this->app->bind(RepositoryInterface::class, TournamentRepository::class);
        $this->app->bind(RepositoryInterface::class, StageRepository::class);
    }

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
