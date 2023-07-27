<?php

namespace Leaguefy\LeaguefyManager\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public static function loadModel(): Model;
    public static function all(): Collection;
    public static function create(array $attributes): Model | null;
    public static function find(string $id): Model | null;

    public static function findBy(string $column, mixed $value): Model | null;
    public static function update(string $id, array $attributes): string;
    public static function delete(string $id): string;
}
