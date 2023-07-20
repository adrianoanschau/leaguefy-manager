<?php

namespace Leaguefy\LeaguefyManager\Models;

use Illuminate\Database\Eloquent\Model;
use Leaguefy\LeaguefyManager\Traits\IsRelationLoaded;

class Game extends Model
{
    use IsRelationLoaded;

    public $hidden = [
        'id',
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

        $this->setTable(config('leaguefy-manager.database.tables.games'));

        parent::__construct($attributes);
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
