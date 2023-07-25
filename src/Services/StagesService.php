<?php

namespace Leaguefy\LeaguefyManager\Services;

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

    public function find(int $id)
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

    public function update(int $stageId, UpdateStageRequest $request)
    {
        $tournament = $this->tournamentRepository->findBy('slug', $request->tournament);

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

    public function connect(ConnectStageRequest $request)
    {
        $tournament = $this->tournamentRepository->findBy('slug', $request->tournament);

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

    public function destroy(int $id)
    {
        return $this->repository->delete($id);
    }
}
