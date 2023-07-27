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
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')
                ->unique();
            $table->foreignUuid('game_id');
            $table->boolean('open_for_subscriptions')
                ->default(0);
            $table->enum('status', TournamentStatus::values())
                ->default(TournamentStatus::CREATED());
            $table->timestamps();

            $table->foreign('game_id')
                ->references('id')
                ->on(config('leaguefy-manager.database.tables.games'));
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
