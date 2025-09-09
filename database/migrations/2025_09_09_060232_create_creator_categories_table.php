<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This method creates the 'creator_categories' pivot table.
     */
    public function up(): void
    {
        Schema::create('creator_categories', function (Blueprint $table) {
            // These two columns will hold the IDs of the related records.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // This ensures that a single creator cannot be linked to the same category more than once.
            $table->primary(['user_id', 'category_id']);

            // Optional: You can add timestamps to track when the relationship was created.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method drops the 'creator_categories' table if the migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('creator_categories');
    }
};
