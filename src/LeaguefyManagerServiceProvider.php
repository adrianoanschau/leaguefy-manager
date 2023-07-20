<?php

namespace Leaguefy\LeaguefyManager;

use Illuminate\Support\ServiceProvider;

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
    }
}
