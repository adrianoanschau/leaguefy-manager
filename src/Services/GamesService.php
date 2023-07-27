<?php

namespace Leaguefy\LeaguefyManager\Services;

use Illuminate\Support\Str;
use Leaguefy\LeaguefyManager\Repositories\GameRepository;
use Leaguefy\LeaguefyManager\Requests\StoreGameRequest;
use Leaguefy\LeaguefyManager\Requests\UpdateGameRequest;

class GamesService
{
    public function __construct(
        private GameRepository $repository
    ) {}

    public function list()
    {
        return $this->repository->all();
    }

    public function find(string $id)
    {
        return $this->repository->find($id);
    }

    public function store(StoreGameRequest $request)
    {
        return $this->repository->create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ]);
    }

    public function update(string $id, UpdateGameRequest $request)
    {
        $game = $this->repository->find($id);

        if ($request->name) {
            $game->name = $request->name;
            $game->slug = Str::slug($request->name, '-');
        }

        return $game->save();
    }

    public function destroy(string $id)
    {
        return $this->repository->delete($id);
    }
}
