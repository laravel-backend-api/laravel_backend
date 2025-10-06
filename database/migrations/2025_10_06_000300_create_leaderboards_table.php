<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaderboards', function (Blueprint $table) {
            $table->id();
            $table->enum('period', ['daily', 'weekly', 'monthly', 'lifetime']);
            $table->enum('role', ['user', 'creator']);
            $table->json('rank_json');
            $table->timestamp('computed_at');
            $table->timestamps();
            $table->unique(['period', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaderboards');
    }
};


