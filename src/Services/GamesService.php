<?php

namespace Leaguefy\LeaguefyManager\Services;

use Leaguefy\LeaguefyManager\Models\Game;

class GamesService
{
    public function __construct(private Game $model) {}

    public function list()
    {
        return $this->model->all()->load(['teams', 'tournaments']);
    }
}
