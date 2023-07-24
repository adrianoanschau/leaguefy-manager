<?php

namespace Leaguefy\LeaguefyManager\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Leaguefy\LeaguefyManager\Models\Game;
use Leaguefy\LeaguefyManager\Models\Tournament;

class TournamentsService
{
    public function __construct(private Tournament $model) {}

    public function list()
    {
        return $this->model->all();
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),
            [
                'name' => 'required',
                'game' => 'required',
            ],
        );

        if ($validate->fails()) {
            throw new Exception($validate->errors());
        }

        $game = Game::where('slug', $request->game)->first();

        return $game->tournaments()->create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ]);
    }

    public function find(int $id)
    {
        return Tournament::find($id);
    }

    public function update(int $id, Request $request)
    {
        $validate = Validator::make($request->all(),
            ['name' => 'string'],
        );

        if ($validate->fails()) {
            throw new Exception($validate->errors());
        }

        $tournament = $this->find($id);

        if ($request->name) {
            $tournament->name = $request->name;
            $tournament->slug = Str::slug($request->name, '-');
        }

        return $tournament->save();
    }

    public function destroy(int $id)
    {
        return Tournament::destroy($id);
    }
}
