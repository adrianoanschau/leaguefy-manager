<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentConfigsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('leaguefy-manager.database.tables.configs'), function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('tournament_id')
                ->unique();
            $table->foreign('tournament_id')
                ->references('id')
                ->on(config('leaguefy-manager.database.tables.tournaments'))
                ->onDelete('cascade');
            $table->json('options')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('leaguefy-manager.database.tables.configs'));
    }
};
