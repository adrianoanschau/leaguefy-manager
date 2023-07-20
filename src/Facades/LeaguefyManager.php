<?php

namespace Leaguefy\LeaguefyManager\Facades;

use Illuminate\Support\Facades\Facade;

class LeaguefyManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Leaguefy\LeaguefyManager\LeaguefyManager::class;
    }
}
