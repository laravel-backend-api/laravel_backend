<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This method creates the 'categories' table.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // The display name of the category.
            $table->string('name');

            // The URL-friendly slug, which should be unique.
            $table->string('slug')->unique();

            // The display order for the categories.
            $table->integer('order')->default(0);

            // A flag to indicate if the category is active.
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method drops the 'categories' table if the migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
