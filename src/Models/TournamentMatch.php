<?php

namespace Leaguefy\LeaguefyManager\Models;

class TournamentMatch extends Model
{
    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('leaguefy-manager.database.tables.matches'));
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function left_team()
    {
        return $this->belongsTo(Team::class, 'left_team_id');
    }

    public function right_team()
    {
        return $this->belongsTo(Team::class, 'right_team_id');
    }
}
