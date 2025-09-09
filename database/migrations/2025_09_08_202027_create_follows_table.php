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
        Schema::create('follows', function (Blueprint $table) {
            // No primary key, as this is a simple pivot table.
            
            // The ID of the user who is doing the following.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // The ID of the user who is being followed (the creator).
            // This references the same 'users' table.
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');

            // This ensures that a user can only follow a creator once.
            $table->unique(['user_id', 'creator_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
