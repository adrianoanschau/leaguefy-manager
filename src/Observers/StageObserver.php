<?php

namespace Leaguefy\LeaguefyManager\Observers;

use Leaguefy\LeaguefyManager\Enums\StageTypes;
use Leaguefy\LeaguefyManager\Models\Stage;

class StageObserver
{
    private function defaults()
    {
        return collect([
            'type' => StageTypes::SINGLE(),
            'lane' => 0,
            'position' => 0,
            'groups' => json_encode([["size" => 2]]),
        ]);
    }

    /**
     * Handle the Stage "creating" event.
     */
    public function creating(Stage $stage): void
    {
        $defaults = $this->defaults();

        collect($stage->getAttributes())->map(function ($value, $attribute) use (&$stage, $defaults) {
            if ($defaults->keys()->contains($attribute) && is_null($value)) {
                $stage->$attribute = $defaults->get($attribute);
            }
        });
    }

    public function created(Stage $stage): void
    {
        $parent = Stage::where('lane', $stage->lane - 1)->where('position', $stage->position)->first();

        if (!is_null($parent)) {
            $stage->parents()->attach($parent->id);
        }
    }

    public function deleted(Stage $stage): void
    {
        $sameLaneEmpty = Stage::where('lane', $stage->lane)->count() === 0;

        if($sameLaneEmpty) {
            Stage::where('lane', '>', $stage->lane)
                ->get()
                ->map(function ($st) {
                    $st->decrement('lane');
                });
        }

        Stage::where('lane', $stage->lane)
            ->where('position', '>', $stage->position)
            ->get()
            ->map(function ($st) {
                $st->decrement('position');
            });
    }
}
