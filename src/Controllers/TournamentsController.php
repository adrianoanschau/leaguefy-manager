<?php

namespace Leaguefy\LeaguefyManager\Controllers;

use Leaguefy\LeaguefyManager\Requests\StoreTournamentRequest;
use Leaguefy\LeaguefyManager\Requests\UpdateTournamentRequest;
use Leaguefy\LeaguefyManager\Services\TournamentsService;

class TournamentsController extends Controller
{
    public function __construct(
        private TournamentsService $service,
    ) {
        $this->include(['config', 'game', 'stages', 'subscribers', 'matches']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tournaments = $this->service->list()
            ->load(['config', 'game', 'stages', 'subscribers', 'matches']);

        return $this->data($tournaments)
            ->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTournamentRequest $request)
    {
        $tournament = $this->service->store($request)
            ->load(['game', 'config', 'stages']);

        return $this
            ->data($tournament)
            ->message('Tournament Created Successfully')
            ->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $tournament = $this->service->find($id)
            ->load(['config', 'game', 'stages', 'subscribers', 'matches']);

        return $this->data($tournament)
            ->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, UpdateTournamentRequest $request)
    {
        $tournament = $this->service->update($id, $request)
            ->load(['config', 'game', 'stages', 'subscribers', 'matches']);

        return $this->data($tournament)
            ->message('Tournament Updated Successfully')
            ->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->service->destroy($id);

        return $this->message('Tournament Removed Successfully')
            ->response();
    }
}
