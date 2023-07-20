<?php

return [
    'route' => [
        'prefix' => env('LEAGUEFY_ROUTE_PREFIX', 'api/leaguefy/v1'),
        'middleware' => [],
    ],

    'database' => [
        'connection' => '',

        'tables' => [
            'games' => 'leaguefy_games',
            'tournaments' => 'leaguefy_tournaments',
            'teams' => 'leaguefy_teams',
            'tournaments_teams' => 'leaguefy_tournaments_teams',
            'matches' => 'leaguefy_matches',
            'configs' => 'leaguefy_tournament_configs',
        ],
    ],
];
