<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('occurrence_id')->constrained('session_occurrences')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('creator_id');
            $table->text('content');
            $table->bigInteger('points_bid');
            $table->enum('status', ['queued', 'answered', 'refunded'])->default('queued');
            $table->timestamps();
            $table->index(['occurrence_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};


