<?php

namespace Leaguefy\LeaguefyManager\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Leaguefy\LeaguefyManager\Models\Game;
use Leaguefy\LeaguefyManager\Models\Team;

class TeamsService
{
    public function __construct(private Team $model) {}

    public function list()
    {
        return $this->model->all();
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),
            [
                'name' => 'required|string',
                'game' => 'required|string',
            ],
        );

        if ($validate->fails()) {
            throw new Exception($validate->errors());
        }

        $game = Game::where('slug', $request->game)->first();

        return $game->teams()->create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ]);
    }

    public function find(int $id)
    {
        return Team::find($id);
    }

    public function update(int $id, Request $request)
    {
        $validate = Validator::make($request->all(),
            ['name' => 'string'],
        );

        if ($validate->fails()) {
            throw new Exception($validate->errors());
        }

        $team = $this->find($id);

        if ($request->name) {
            $team->name = $request->name;
            $team->slug = Str::slug($request->name, '-');
        }

        return $team->save();
    }

    public function destroy(int $id)
    {
        return Team::destroy($id);
    }
}
