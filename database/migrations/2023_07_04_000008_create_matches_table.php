<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('leaguefy-manager.database.tables.matches'), function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stage');
            $table->integer('round');
            $table->integer('group');
            $table->integer('match');
            $table->unsignedBigInteger('left_team_id');
            $table->unsignedBigInteger('right_team_id');
            $table->unsignedBigInteger('tournament_id');
            $table->integer('left_score')
                ->nullable();
            $table->integer('right_score')
                ->nullable();
            $table->timestamps();

            $table->foreign('left_team_id')
                ->references('id')
                ->on(config('leaguefy-manager.database.tables.teams'))
                ->onDelete('cascade');
            $table->foreign('right_team_id')
                ->references('id')
                ->on(config('leaguefy-manager.database.tables.teams'))
                ->onDelete('cascade');
            $table->foreign('tournament_id')
                ->references('id')
                ->on(config('leaguefy-manager.database.tables.tournaments'))
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
        Schema::dropIfExists(config('leaguefy-manager.database.tables.matches'));
    }
}
