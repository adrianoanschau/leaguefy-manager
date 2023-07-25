<?php

namespace Leaguefy\LeaguefyManager\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Leaguefy\LeaguefyManager\Traits\ApiResource;

class Controller extends BaseController
{
    use ApiResource, AuthorizesRequests, ValidatesRequests;
}
