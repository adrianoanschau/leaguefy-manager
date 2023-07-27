<?php

namespace Leaguefy\LeaguefyManager\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Stage extends Model
{
    public $hidden = [
        'tournament_id',
    ];

    public $fillable = [
        'name',
        'type',
        'lane',
        'position',
        'groups',
        'competitors',
        'classify'
    ];

    public $casts = [
        'position' => 'integer',
        'lane' => 'integer',
        'competitors' => 'integer',
        'classify' => 'integer',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('leaguefy-manager.database.tables.stages'));
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
