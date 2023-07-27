<?php

namespace Leaguefy\LeaguefyManager\Models;

class Tournament extends Model
{
    public $hidden = [
        'game_id',
    ];

    public $fillable = [
        'name',
        'slug',
        'status',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('leaguefy-manager.database.tables.tournaments'));
    }

    public function config()
    {
        return $this->hasOne(TournamentConfig::class)->withDefault([
            'options' => collect([]),
        ]);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }

    public function subscribers()
    {
        return $this->belongsToMany(
            Team::class,
            config('leaguefy-manager.database.tables.tournaments_teams'),
            'tournament_id',
            'team_id',
        )->withPivot('stage_entry');
    }

    public function matches()
    {
        return $this->hasMany(TournamentMatch::class, 'tournament_id');
    }
}
