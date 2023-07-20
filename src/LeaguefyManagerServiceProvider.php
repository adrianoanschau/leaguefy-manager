<?php

namespace Leaguefy\LeaguefyManager;

use Illuminate\Support\ServiceProvider;

class LeaguefyManagerServiceProvider extends ServiceProvider
{
    public function boot(LeaguefyManager $manager)
    {
        if ($this->app->runningInConsole() && $manager->migrations) {
            $this->publishes([__DIR__.'/../config' => config_path()], 'leaguefy-manager');

            $this->loadMigrationsFrom($manager->migrations);
        }

        $this->app->booted(fn () => $manager->routes());
    }
}
