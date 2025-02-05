<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('matchups', function (Blueprint $table) {
            $table->id();
            $table->integer('player1_score')->nullable();
            $table->integer('player2_score')->nullable();
            $table->string('finish_type')->nullable();
            $table->foreignId('winner_id')->nullable()->constrained('players');
            $table->foreignId('game_id');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matchups');
    }
};
