<?php

namespace Leaguefy\LeaguefyManager\Services;

use Illuminate\Support\Str;
use Leaguefy\LeaguefyManager\Repositories\GameRepository;
use Leaguefy\LeaguefyManager\Repositories\TeamRepository;
use Leaguefy\LeaguefyManager\Requests\StoreTeamRequest;
use Leaguefy\LeaguefyManager\Requests\UpdateTeamRequest;

class TeamsService
{
    public function __construct(
        private TeamRepository $repository,
        private GameRepository $gameRepository,
    ) {}
    public function list()
    {
        return $this->repository->all();
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function store(StoreTeamRequest $request)
    {
        $game = $this->gameRepository->findBy('slug', $request->game);

        return $game->teams()->create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ]);
    }

    public function update(int $id, UpdateTeamRequest $request)
    {
        $team = $this->repository->find($id);

        if ($request->name) {
            $team->name = $request->name;
            $team->slug = Str::slug($request->name, '-');
        }

        return $team->save();
    }

    public function destroy(int $id)
    {
        return $this->repository->delete($id);
    }
}
