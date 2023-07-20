<?php

namespace Leaguefy\LeaguefyManager\Traits;

trait IsRelationLoaded
{
    public function isLoaded($key)
    {
        return array_key_exists($key, $this->relations);
    }
}
