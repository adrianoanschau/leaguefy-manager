<?php

namespace Leaguefy\LeaguefyManager\Models;

use Illuminate\Database\Eloquent\Model;
use Leaguefy\LeaguefyManager\Traits\IsRelationLoaded;

class Tournament extends Model
{
    use IsRelationLoaded;

    public $hidden = [
        'id',
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
        $connection = config('leaguefy-manager.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('leaguefy-manager.database.tables.tournaments'));

        parent::__construct($attributes);
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
