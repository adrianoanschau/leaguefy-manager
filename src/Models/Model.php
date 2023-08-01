<?php

namespace Leaguefy\LeaguefyManager\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Leaguefy\LeaguefyManager\Traits\IsRelationLoaded;
use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{
    use IsRelationLoaded, HasUuids;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $connection = config('leaguefy-manager.database.connection') ?: config('database.default');

        $this->setConnection($connection);
    }
}
