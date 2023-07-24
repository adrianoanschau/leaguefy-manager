<?php

namespace Leaguefy\LeaguefyManager\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Leaguefy\LeaguefyManager\Models\Game;

class GamesService
{
    public function __construct(private Game $model) {}

    public function list()
    {
        return $this->model->all();
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),
            ['name' => 'required|string'],
        );

        if ($validate->fails()) {
            throw new Exception($validate->errors());
        }

        return Game::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ]);
    }

    public function find(int $id)
    {
        return Game::find($id);
    }

    public function update(int $id, Request $request)
    {
        $validate = Validator::make($request->all(),
            ['name' => 'string'],
        );

        if ($validate->fails()) {
            throw new Exception($validate->errors());
        }

        $game = $this->find($id);

        if ($request->name) {
            $game->name = $request->name;
            $game->slug = Str::slug($request->name, '-');
        }

        return $game->save();
    }

    public function destroy(int $id)
    {
        return Game::destroy($id);
    }
}
