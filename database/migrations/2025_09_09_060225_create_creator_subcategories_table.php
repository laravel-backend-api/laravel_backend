<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This method creates the 'creator_subcategories' pivot table.
     */
    public function up(): void
    {
        Schema::create('creator_subcategories', function (Blueprint $table) {
            // These two columns will hold the IDs of the related records.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subcategory_id')->constrained()->onDelete('cascade');

            // This ensures that a single creator cannot be linked to the same subcategory more than once.
            $table->primary(['user_id', 'subcategory_id']);

            // Optional: You can add timestamps to track when the relationship was created.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method drops the 'creator_subcategories' table if the migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('creator_subcategories');
    }
};
