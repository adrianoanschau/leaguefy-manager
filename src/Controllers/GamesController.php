<?php

namespace Leaguefy\LeaguefyManager\Controllers;

use Illuminate\Http\Request;
use Leaguefy\LeaguefyManager\Services\GamesService;
use Leaguefy\LeaguefyManager\Traits\ApiResource;

class GamesController extends Controller
{
    use ApiResource;

    public function __construct(
        private GamesService $gamesService,
    ) {
        $this->include(['teams', 'tournaments']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = $this->gamesService->list()->load(['teams', 'tournaments']);

        return $this->data($games)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $game = $this->gamesService->store($request);

            return $this
                ->data($game)
                ->message('Game Created Successfully')
                ->response();

        } catch (\Throwable $th) {
            return $this
                ->status(500)
                ->message($th->getMessage())
                ->response();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return $this->data($this->gamesService->find($id)->load(['teams']))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, Request $request)
    {
        return $this->gamesService->update($id, $request)->load(['teams']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        return $this->gamesService->destroy($id);
    }
}
