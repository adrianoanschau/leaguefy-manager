<?php

namespace Leaguefy\LeaguefyManager\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentMatch extends Model
{
    protected $hidden = [
        'id',
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

        $this->setTable(config('leaguefy-manager.database.tables.matches'));

        parent::__construct($attributes);
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
