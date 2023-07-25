<?php

namespace Leaguefy\LeaguefyManager\Controllers;

use Leaguefy\LeaguefyManager\Requests\StoreTeamRequest;
use Leaguefy\LeaguefyManager\Requests\UpdateTeamRequest;
use Leaguefy\LeaguefyManager\Services\TeamsService;

class TeamsController extends Controller
{
    public function __construct(
        private TeamsService $service,
    ) {
        $this->include(['game', 'tournaments']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = $this->service->list()
            ->load(['game', 'tournaments']);

        return $this->data($teams)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        $team = $this->service->store($request)
            ->load(['game']);

        return $this
            ->data($team)
            ->message('Team Created Successfully')
            ->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $team = $this->service->find($id)
            ->load(['game', 'tournaments']);

        return $this->data($team)
            ->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, UpdateTeamRequest $request)
    {
        $team = $this->service->update($id, $request)
            ->load(['game', 'tournaments']);

        return $this->data($team)
            ->message('Team Updated Successfully')
            ->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->service->destroy($id);

        return $this->message('Team Removed Successfully')
            ->response();
    }
}
