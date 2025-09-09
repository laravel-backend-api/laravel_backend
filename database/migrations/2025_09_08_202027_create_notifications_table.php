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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // The user receiving the notification.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // The type of notification (e.g., 'booking_reminder', 'new_follower').
            $table->string('type');
            
            // The notification payload, stored as JSON.
            $table->json('payload');
            
            // Timestamp for when the notification was sent.
            $table->timestamp('sent_at')->useCurrent();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
