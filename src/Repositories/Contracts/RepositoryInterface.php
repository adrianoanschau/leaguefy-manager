<?php

namespace Leaguefy\LeaguefyManager\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public static function loadModel(): Model;
    public static function all(): Collection;
    public static function create(array $attributes): Model | null;
    public static function find(int $id): Model | null;

    public static function findBy(string $column, mixed $value): Model | null;
    public static function update(int $id, array $attributes): int;
    public static function delete(int $id): int;
}
