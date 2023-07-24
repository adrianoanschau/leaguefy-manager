<?php

namespace Leaguefy\LeaguefyManager;

use Illuminate\Support\Facades\Route;

class LeaguefyManager
{
    public $migrations = __DIR__.'/../database/migrations';

    public $api_routes = __DIR__.'/../routes/api.php';

    public function routes()
    {
        Route::group([
            'prefix'     => config('leaguefy-manager.route.prefix'),
            'middleware' => config('leaguefy-manager.route.middleware'),
            'as' => 'leaguefy.api.',
        ], $this->api_routes);
    }
}
