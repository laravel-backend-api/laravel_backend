<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This method creates the 'subcategories' table.
     */
    public function up(): void
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();

            // The foreign key linking this subcategory to a category.
            // On delete, the subcategory will be deleted as well.
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            // The display name of the subcategory.
            $table->string('name');

            // The URL-friendly slug, which should be unique.
            $table->string('slug')->unique();

            // A flag to indicate if the subcategory is active.
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method drops the 'subcategories' table.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcategories');
    }
};
