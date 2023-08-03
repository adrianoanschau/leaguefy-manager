<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Leaguefy\LeaguefyManager\Enums\StageTypes;

class CreateStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('leaguefy-manager.database.tables.stages'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')
                ->nullable();
            $table->enum('type', StageTypes::values())
                ->default(StageTypes::SINGLE());
            $table->integer('lane')
                ->default(0);
            $table->integer('position')
                ->default(0);
            $table->integer('competitors')
                ->default(4);
            $table->json('groups')
                ->default(json_encode([["size" => 4]]));
            $table->foreignUuid('tournament_id');
            $table->timestamps();

            $table->unique(['tournament_id', 'lane', 'position']);
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
        Schema::dropIfExists(config('leaguefy-manager.database.tables.stages'));
    }
}
