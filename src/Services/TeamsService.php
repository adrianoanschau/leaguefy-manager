<?php

namespace Leaguefy\LeaguefyManager\Services;

use Leaguefy\LeaguefyManager\Models\Team;

class TeamsService
{
    public function __construct(private Team $model) {}

    public function list()
    {
        return $this->model->all()->load(['game']);
    }
}
