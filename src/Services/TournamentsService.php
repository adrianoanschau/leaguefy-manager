<?php

namespace Leaguefy\LeaguefyManager\Services;

use Leaguefy\LeaguefyManager\Models\Tournament;

class TournamentsService
{
    public function __construct(private Tournament $model) {}

    public function list()
    {
        return $this->model->all()->load(['game']);
    }
}
