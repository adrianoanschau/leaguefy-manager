<?php

namespace Leaguefy\LeaguefyManager\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Leaguefy\LeaguefyManager\Models\Game;
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
        $games = $this->gamesService->list();

        return $this->data($games)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(),
                ['name' => 'required'],
            );

            if ($validate->fails()) {
                return $this
                    ->status(400)
                    ->errors($validate->errors())
                    ->message('Validation error')
                    ->response();
            }

            $game = Game::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-'),
            ]);

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
    public function show(int $game)
    {
        return $this->data(Game::find($game)->load(['teams']))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        //
    }
}
