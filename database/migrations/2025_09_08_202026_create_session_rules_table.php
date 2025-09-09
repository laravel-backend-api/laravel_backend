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
        Schema::create('session_rules', function (Blueprint $table) {
            $table->id();
            
            // The template this rule belongs to.
            $table->foreignId('template_id')->constrained('session_templates')->onDelete('cascade');
            
            // The weekly pattern for this rule.
            $table->string('weekday'); // e.g., 'Monday', 'Tuesday'
            $table->time('start_time');
            $table->time('end_time');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_rules');
    }
};
