<?php

namespace Leaguefy\LeaguefyManager\Models;

use Illuminate\Database\Eloquent\Model;
use Leaguefy\LeaguefyManager\Traits\IsRelationLoaded;

class Team extends Model
{
    use IsRelationLoaded;

    public $hidden = [
        'id',
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
        $connection = config('leaguefy-manager.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('leaguefy-manager.database.tables.teams'));

        parent::__construct($attributes);
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
