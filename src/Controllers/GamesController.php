<?php

namespace Leaguefy\LeaguefyManager\Controllers;

use Leaguefy\LeaguefyManager\Requests\StoreGameRequest;
use Leaguefy\LeaguefyManager\Requests\UpdateGameRequest;
use Leaguefy\LeaguefyManager\Services\GamesService;

class GamesController extends Controller
{
    public function __construct(
        private GamesService $service,
    ) {
        $this->include(['teams', 'tournaments']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = $this->service->list()
            ->load(['teams', 'tournaments']);

        return $this->data($games)
            ->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGameRequest $request
     */
    public function store(StoreGameRequest $request)
    {
        $game = $this->service->store($request);

        return $this
            ->data($game)
            ->message('Game Created Successfully')
            ->response();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show(int $id)
    {
        $game = $this->service->find($id)
            ->load(['teams', 'tournaments']);

        return $this->data($game)
            ->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param UpdateGameRequest $request
     */
    public function update(int $id, UpdateGameRequest $request)
    {
        $game = $this->service->update($id, $request)
            ->load(['teams', 'tournaments']);

        return $this->data($game)
            ->message('Game Updated Successfully')
            ->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $this->service->destroy($id);

        return $this->message('Game Removed Successfully')
            ->response();
    }
}
