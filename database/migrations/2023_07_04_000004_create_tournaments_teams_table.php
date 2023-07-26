<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTournamentsTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            config('leaguefy-manager.database.tables.tournaments_teams'),
            function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('tournament_id');
                $table->unsignedInteger('team_id');
                $table->integer('stage_entry')
                    ->default(0);
                $table->integer('rank')
                    ->default(0);
                $table->timestamps();

                $table->foreign('tournament_id')
                    ->references('id')
                    ->on(config('leaguefy-manager.database.tables.tournaments'))
                    ->onDelete('cascade');
                $table->foreign('team_id')
                    ->references('id')
                    ->on(config('leaguefy-manager.database.tables.teams'))
                    ->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('leaguefy-manager.database.tables.tournaments_teams'));
    }
}
