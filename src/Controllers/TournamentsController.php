<?php

namespace Leaguefy\LeaguefyManager\Controllers;

use Illuminate\Http\Request;
use Leaguefy\LeaguefyManager\Services\TournamentsService;
use Leaguefy\LeaguefyManager\Traits\ApiResource;

class TournamentsController extends Controller
{
    use ApiResource;

    public function __construct(
        private TournamentsService $tournamentsService,
    ) {
        $this->include(['game', 'stages']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tournaments = $this->tournamentsService->list()->load(['game', 'stages']);

        return $this->data($tournaments)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $tournament = $this->tournamentsService->store($request)->load(['game', 'stages']);

            return $this
                ->data($tournament)
                ->message('Tournament Created Successfully')
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
        return $this->data($this->tournamentsService->find($id)->load(['game', 'stages']))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, Request $request)
    {
        return $this->tournamentsService->update($id, $request)->load(['game', 'stages']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        return $this->tournamentsService->destroy($id);
    }
}
