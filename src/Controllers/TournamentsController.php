<?php

namespace Leaguefy\LeaguefyManager\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Leaguefy\LeaguefyManager\Models\Game;
use Leaguefy\LeaguefyManager\Models\Tournament;
use Illuminate\Http\Request;
use Leaguefy\LeaguefyManager\Services\TournamentsService;
use Leaguefy\LeaguefyManager\Traits\ApiResource;

class TournamentsController extends Controller
{
    use ApiResource;

    public function __construct(
        private TournamentsService $tournamentsService,
    ) {
        $this->include(['game']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tournaments = $this->tournamentsService->list();

        return $this->data($tournaments)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'game' => 'required',
                ],
            );

            if ($validate->fails()) {
                return $this
                    ->status(400)
                    ->errors($validate->errors())
                    ->message('Validation error')
                    ->response();
            }

            $game = Game::where('slug', $request->game)->first();

            $tournament = $game->tournaments()->create([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-'),
            ])->load(['game']);

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
    public function show(int $tournament)
    {
        return $this->data(Tournament::find($tournament)->load(['game']))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tournament $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $game)
    {
        //
    }
}
