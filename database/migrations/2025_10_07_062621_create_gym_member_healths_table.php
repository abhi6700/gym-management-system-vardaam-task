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
        Schema::create('gym_member_healths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gym_member_id')
                ->constrained('gym_members')
                ->onDelete('cascade');
            $table->date('date');
            $table->decimal('height');
            $table->decimal('weight');
            $table->decimal('bmi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_member_healths');
    }
};
