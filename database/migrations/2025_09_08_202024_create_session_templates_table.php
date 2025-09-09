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
        Schema::create('session_templates', function (Blueprint $table) {
            $table->id();
            
            // The room this template is associated with.
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            
            // Basic session information.
            $table->string('title');
            $table->text('description')->nullable();
            
            // Capacity and status of the template.
            $table->integer('capacity')->default(0);
            $table->string('status')->default('active');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_templates');
    }
};
