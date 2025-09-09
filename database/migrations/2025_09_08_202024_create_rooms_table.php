<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This method creates the 'rooms' table for live sessions.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            // The creator of the room, linked to the 'users' table.
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');

            // The Zoom link for the live session.
            $table->string('zoom_link');

            // A flag to indicate if the room is active and can be used.
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method drops the 'rooms' table.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
