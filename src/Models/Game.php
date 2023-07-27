<?php

namespace Leaguefy\LeaguefyManager\Models;

class Game extends Model
{
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

        $this->setTable(config('leaguefy-manager.database.tables.games'));
    }

    public function tournaments()
    {
        return $this->hasMany(Tournament::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
