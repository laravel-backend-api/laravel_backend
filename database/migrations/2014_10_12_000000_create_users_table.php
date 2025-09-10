<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            
            // The user's role (e.g., 'creator', 'user').
            $table->string('role');

            $table->string('email')->unique();

            $table->string('password');

            $table->string('timezone') -> nullable();

            // The user's status (e.g., 'active', 'suspended').
            $table->string('status') -> default('active');

            // The remember token for the "remember me" functionality.
            // $table->rememberToken();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method drops the 'users' table if the migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
