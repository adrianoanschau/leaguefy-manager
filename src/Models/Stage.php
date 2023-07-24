<?php

namespace Leaguefy\LeaguefyManager\Models;

use Illuminate\Database\Eloquent\Model;
use Leaguefy\LeaguefyManager\Enums\StageTypes;
use Leaguefy\LeaguefyManager\Traits\IsRelationLoaded;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Stage extends Model
{
    use IsRelationLoaded;

    public $hidden = [
        'id',
        'tournament_id',
    ];

    public $fillable = [
        'name',
        'type',
        'lane',
        'position',
        'groups',
    ];

    public $casts = [
        'position' => 'integer',
        'lane' => 'integer',
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

        $this->setTable(config('leaguefy-manager.database.tables.stages'));

        parent::__construct($attributes);
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    protected function groups(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true, 3),
            set: fn ($value) => json_encode($value),
        );
    }

    public function children()
    {
        return $this->belongsToMany(
            Stage::class,
            config('leaguefy-manager.database.tables.stage_parents'),
            'parent_id',
            'stage_id',
        );
    }

    public function parents()
    {
        return $this->belongsToMany(
            Stage::class,
            config('leaguefy-manager.database.tables.stage_parents'),
            'stage_id',
            'parent_id',
        );
    }
}
