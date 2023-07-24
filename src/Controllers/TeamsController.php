<?php

namespace Leaguefy\LeaguefyManager\Controllers;

use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        try {
            $team = $this->teamsService->store($request)->load(['game']);

            return $this
                ->data($team)
                ->message('Team Created Successfully')
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
        return $this->data($this->teamsService->find($id)->load(['game']))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, Request $request)
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
