<?php

namespace Leaguefy\LeaguefyManager\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Leaguefy\LeaguefyManager\Enums\StageTypes;
use Leaguefy\LeaguefyManager\Models\Stage;
use Leaguefy\LeaguefyManager\Models\Tournament;

class StagesService
{
    public function __construct(private Stage $model) {}

    public function find(int $id)
    {
        return Stage::find($id);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),
            [
                'tournament' => 'required|string',
                'lane' => 'integer|nullable',
                'position' => 'integer|nullable',
                'laneInsert' => 'string|nullable',
                'positionInsert' => 'string|nullable',
            ],
        );

        if ($validate->fails()) {
            throw new Exception($validate->errors());
        }

        $tournament = Tournament::where('slug', $request->tournament)->first();

        $all = $tournament->stages;
        $lane = $request->lane;
        $position = $request->position;

        if (isset($request->laneInsert)) {
            if ($request->laneInsert === 'start') {
                $lane = 0;
                $all->sortBy('lane')->reverse()->map(function ($stage) {
                    $stage->increment('lane');
                });
            }

            if ($request->laneInsert === 'end') {
                $lane = $all->isEmpty() ? 0 : $all->max('lane') + 1;
            }
        }

        if (isset($request->positionInsert)) {
            if ($request->positionInsert === 'start') {
                $position = 0;
                $all->filter(fn ($v) => $v['lane'] === $lane)
                    ->sortBy('position')->reverse()->map(function ($stage) {
                        $stage->increment('position');
                    });
            }

            if ($request->positionInsert === 'end') {
                $position = $all->isEmpty() ? 0 : $all->filter(fn ($v) => $v['lane'] === $lane)->max('position') + 1;
            }
        }

        return $tournament->stages()->create([
            'lane' => $lane,
            'position' => $position,
        ]);
    }

    public function update(int $stageId, Request $request)
    {
        $validate = Validator::make($request->all(),
            [
                'tournament' => 'required|string',
                'name' => 'string|nullable',
                'type' => [new Enum(StageTypes::class)],
                'competitors' => 'integer|nullable',
                'classify' => 'integer|nullable',
            ],
        );

        if ($validate->fails()) {
            throw new Exception($validate->errors());
        }

        $tournament = Tournament::where('slug', $request->tournament)->first();

        $update = [];

        if (!is_null($request->name)) {
            $update['name'] = $request->name;
        }

        if (!is_null($request->type)) {
            $update['type'] = $request->type;
        }

        if (!is_null($request->competitors)) {
            $update['competitors'] = $request->competitors;
        }

        if (!is_null($request->classify)) {
            $update['classify'] = $request->classify;
        }

        return $tournament->stages->find($stageId)->update($update);
    }

    public function connect(Request $request)
    {
        $validate = Validator::make($request->all(),
            [
                'tournament' => 'required|string',
                'parent' => 'array:lane,position',
                'child' => 'array:lane,position',
            ],
        );

        if ($validate->fails()) {
            throw new Exception($validate->errors());
        }

        $tournament = Tournament::where('slug', $request->tournament)->first();

        $parent = $tournament->stages
            ->where('lane', $request->parent['lane'])
            ->where('position', $request->parent['position'])
            ->first();

        $child = $tournament->stages
            ->where('lane', $request->child['lane'])
            ->where('position', $request->child['position'])
            ->first();

        if (!is_null($parent->children->find($child->id))) {
            $parent->children()->detach($child->id);

            return 'disconnected';
        }

        $parent->children()->attach($child->id);

        return 'connected';
    }

    public function destroy(int $stage)
    {
        return Stage::destroy($stage);
    }
}