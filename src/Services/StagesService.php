<?php

namespace Leaguefy\LeaguefyManager\Services;

use Leaguefy\LeaguefyManager\Enums\StageTypes;
use Leaguefy\LeaguefyManager\Repositories\StageRepository;
use Leaguefy\LeaguefyManager\Repositories\TournamentRepository;
use Leaguefy\LeaguefyManager\Requests\ConnectStageRequest;
use Leaguefy\LeaguefyManager\Requests\StoreStageRequest;
use Leaguefy\LeaguefyManager\Requests\UpdateStageRequest;

class StagesService
{
    public function __construct(
        private StageRepository $repository,
        private TournamentRepository $tournamentRepository,
    ) {}

    public function find(string $id)
    {
        return $this->repository->find($id);
    }

    public function store(StoreStageRequest $request)
    {
        $tournament = $this->tournamentRepository->findBy('slug', $request->tournament);

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

    public function update(string $stageId, UpdateStageRequest $request)
    {
        $tournament = $this->tournamentRepository->findBy('slug', $request->tournament);
        $stage = $tournament->stages->find($stageId);
        $type = $stage->type;

        $update = [];

        if (!is_null($request->name)) {
            $update['name'] = $request->name;
        }

        if (!is_null($request->type)) {
            $update['type'] = $request->type;
            $type = $request->type;
        }

        if ($type === StageTypes::SINGLE()) {
            if (!is_null($request->competitors)) {
                $update['competitors'] = $request->competitors;
                $update['groups'] = [['size' => $request->competitors]];
            } else {
                $update['competitors'] = 4;
                $update['groups'] = [['size' => 4]];
            }
        }

        if ($type === StageTypes::MULTIPLE()) {
            if (!is_null($request->groups)) {
                $update['competitors'] = collect($request->groups)->sum('size');
                $update['groups'] = $request->groups;
            } else {
                $update['competitors'] = 8;
                $update['groups'] = [['size' => 4], ['size' => 4]];
            }
        }

        if ($type === StageTypes::ELIMINATION()) {
            if (!is_null($request->groups) && is_integer($request->groups)) {
                $update['competitors'] = $request->groups * 2;
                $update['groups'] = array_fill(0, $request->groups, ['size' => 2]);
            } else {
                $update['competitors'] = 4;
                $update['groups'] = [['size' => 2], ['size' => 2]];
            }
        }

        if ($type === StageTypes::FINAL()) {
            $update['competitors'] = 2;
            $update['groups'] = [['size' => 2]];
        }

        return $tournament->stages->find($stageId)->update($update);
    }

    public function connect(ConnectStageRequest $request)
    {
        $tournament = $this->tournamentRepository->findBy('slug', $request->tournament);

        $parent = $tournament->stages
            ->find($request->parent);

        $child = $tournament->stages
            ->find($request->child);

        if (!is_null($parent->children->find($child->id))) {
            $parent->children()->detach($child->id);

            return 'disconnected';
        }

        $parent->children()->attach($child->id);

        return 'connected';
    }

    public function destroy(string $id)
    {
        return $this->repository->delete($id);
    }
}
