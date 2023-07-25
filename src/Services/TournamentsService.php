<?php

namespace Leaguefy\LeaguefyManager\Services;

use Illuminate\Support\Str;
use Leaguefy\LeaguefyManager\Repositories\GameRepository;
use Leaguefy\LeaguefyManager\Repositories\TournamentRepository;
use Leaguefy\LeaguefyManager\Requests\StoreTournamentRequest;
use Leaguefy\LeaguefyManager\Requests\UpdateTournamentRequest;

class TournamentsService
{
    public function __construct(
        private TournamentRepository $repository,
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

    public function store(StoreTournamentRequest $request)
    {
        $game = $this->gameRepository->findBy('slug', $request->game);

        return $game->tournaments()->create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ]);
    }

    public function update(int $id, UpdateTournamentRequest $request)
    {
        $tournament = $this->repository->find($id);

        if ($request->name) {
            $tournament->name = $request->name;
            $tournament->slug = Str::slug($request->name, '-');
        }

        return $tournament->save();
    }

    public function destroy(int $id)
    {
        return $this->repository->delete($id);
    }
}
