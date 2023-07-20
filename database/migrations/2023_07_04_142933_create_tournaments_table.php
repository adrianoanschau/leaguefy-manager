<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Leaguefy\LeaguefyManager\Enums\TournamentStatus;

class CreateTournamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('leaguefy-manager.database.tables.tournaments'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')->references('id')->on(config('leaguefy-manager.database.tables.games'));
            $table->boolean('open_for_subscriptions')->default(0);
            $table->enum('status', TournamentStatus::values())->default(TournamentStatus::CREATED());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('leaguefy-manager.database.tables.tournaments'));
    }
}
