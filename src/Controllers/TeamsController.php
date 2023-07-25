<?php

namespace Leaguefy\LeaguefyManager\Controllers;

use Leaguefy\LeaguefyManager\Requests\StoreTeamRequest;
use Leaguefy\LeaguefyManager\Requests\UpdateTeamRequest;
use Leaguefy\LeaguefyManager\Services\TeamsService;
use Leaguefy\LeaguefyManager\Traits\ApiResource;

class TeamsController extends Controller
{
    use ApiResource;

    public function __construct(
        private TeamsService $teamsService,
    ) {
        $this->include(['game']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = $this->teamsService->list()->load(['game']);

        return $this->data($teams)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        $team = $this->teamsService->store($request)->load(['game']);

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
        return $this->data($this->teamsService->find($id)->load(['game']))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, UpdateTeamRequest $request)
    {
        return $this->teamsService->update($id, $request)->load(['game']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        return $this->teamsService->destroy($id);
    }
}
