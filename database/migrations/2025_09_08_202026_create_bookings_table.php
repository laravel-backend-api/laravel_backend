<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This method creates the 'bookings' table for user session reservations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // The ID of the session occurrence being booked, linked to the 'session_occurrences' table.
            $table->foreignId('occurrence_id')->constrained('session_occurrences')->onDelete('cascade');

            // The ID of the user making the booking, linked to the 'users' table.
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // The booking status. Use a string to allow for different states.
            $table->string('status')->default('booked');

            // Timestamp for when the booking was made.
            $table->timestamp('booked_at')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method drops the 'bookings' table.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
