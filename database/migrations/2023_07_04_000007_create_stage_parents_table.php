<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStageParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            config('leaguefy-manager.database.tables.stage_parents'),
            function (Blueprint $table) {
                $table->foreignUuid('stage_id');
                $table->foreignUuid('parent_id');
                $table->timestamps();


                $table->foreign('stage_id')
                    ->references('id')
                    ->on(config('leaguefy-manager.database.tables.stages'))
                    ->onDelete('cascade');
                $table->foreign('parent_id')
                    ->references('id')
                    ->on(config('leaguefy-manager.database.tables.stages'))
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
        Schema::dropIfExists(config('leaguefy-manager.database.tables.stage_parents'));
    }
}
