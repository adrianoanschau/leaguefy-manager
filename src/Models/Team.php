<?php

namespace Leaguefy\LeaguefyManager\Models;

class Team extends Model
{
    public $hidden = [
        'game_id',
    ];

    public $fillable = [
        'name',
        'slug',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('leaguefy-manager.database.tables.teams'));
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function tournaments()
    {
        return $this->belongsToMany(
            Tournament::class,
            config('leaguefy-manager.database.tables.tournaments_teams'),
            'tournament_id',
            'team_id',
        );
    }
}
