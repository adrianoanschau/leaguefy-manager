<?php

namespace Leaguefy\LeaguefyManager\Repositories;

use Leaguefy\LeaguefyManager\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{
    protected static $model;

    public static function loadModel(): Model
    {
        return app(static::$model);
    }

    public static function all(): Collection
    {
        return self::loadModel()::all();
    }

    public static function create(array $attributes = []): Model | null
    {
        return self::loadModel()::query()->create($attributes);
    }

    public static function find(string $id): Model | null
    {
        return self::loadModel()::query()->find($id);
    }

    public static function findBy(string $column, mixed $value): Model | null
    {
        return self::loadModel()::query()->where($column, $value)->first();
    }

    public static function update(string $id, array $attributes = []): string
    {
        return self::loadModel()::query()->where(['id' => $id])->update($attributes);
    }

    public static function delete(string $id): string
    {
        return self::loadModel()::query()->find($id)->delete();
    }

}
