<?php

namespace Leaguefy\LeaguefyManager\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

class TournamentConfig extends Model
{
    protected $fillable = [
        'tournament_id',
        'options',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('leaguefy-manager.database.tables.configs'));
    }

    protected function options(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $value = collect(json_decode($value, true));

                $stages = collect($value->get('stages'))
                    ->map(function ($stage) {
                        $stage['groups'] = collect($stage['groups'])->map(function ($group) {
                            return collect([
                                'size' => (int) $group['size'],
                            ]);
                        });

                        return $stage;
                    });

                $draw = collect($value->get('draw'))
                    ->map(function ($value, $index) {
                        if (str_contains($index, 'stage')) return collect($value)->map(fn ($v) => collect($v));

                        return $value;
                    });

                $champion = Team::find($value->get('champion'));

                return collect(['stages' => $stages, 'draw' => $draw, 'champion' => $champion]);
            },
            set: fn ($value) => json_encode($value),
        );
    }
}
