<?php

namespace Leaguefy\LeaguefyManager\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Leaguefy\LeaguefyManager\Models\Game;
use Leaguefy\LeaguefyManager\Models\Team;
use Illuminate\Http\Request;
use Leaguefy\LeaguefyManager\Traits\ApiResource;

class TeamsController extends Controller
{
    use ApiResource;

    public function __construct() {
        $this->include(['game']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::all()->load(['game']);

        return $this->data($teams)->response();
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

            $team = $game->teams()->create([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-'),
            ])->load(['game']);

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
    public function show(int $team)
    {
        return $this->data(Team::find($team)->load(['game']))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        //
    }
}
