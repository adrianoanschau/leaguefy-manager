<?php

namespace Leaguefy\LeaguefyManager\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'leaguefy-manager:install';

    protected $description = 'Install LeaguefyManager package';

    public function handle()
    {
        $this->call('vendor:publish', [
            '--provider' => 'Leaguefy\LeaguefyManager\LeaguefyManagerServiceProvider',
        ]);
    }
}
