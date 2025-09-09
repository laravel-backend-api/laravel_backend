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
        Schema::create('session_occurrences', function (Blueprint $table) {
            $table->id();
            
            // The template this occurrence was generated from.
            $table->foreignId('template_id')->constrained('session_templates')->onDelete('cascade');
            
            // The actual start and end times of the session occurrence.
            $table->timestamp('start_at') -> nullable();
            $table->timestamp('end_at') -> nullable();

            // Additional details for this specific occurrence.
            $table->integer('capacity')->default(0);
            $table->string('status')->default('upcoming');
            $table->string('drive_link')->nullable();
            
            // Cache for stats to avoid complex queries.
            $table->json('stats_cached_json')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_occurrences');
    }
};
