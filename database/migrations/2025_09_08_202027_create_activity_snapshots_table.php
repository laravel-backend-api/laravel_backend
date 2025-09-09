<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This method creates the 'activity_snapshots' table.
     */
    public function up(): void
    {
        Schema::create('activity_snapshots', function (Blueprint $table) {
            $table->id();

            // This is the polymorphic part. It creates 'entity_type' and 'entity_id' columns.
            // For example, an entry could have entity_type = 'room' and entity_id = 50.
            $table->morphs('entity');

            // The time window for the snapshot (e.g., 'day', 'week', 'month').
            $table->string('window');

            // The raw metrics stored as a JSON object.
            $table->json('metrics_json')->nullable();

            // The pre-calculated score used for sorting.
            $table->double('score')->default(0);

            $table->timestamps();

            // This unique index prevents duplicate snapshots for the same entity and window.
            $table->unique(['entity_type', 'entity_id', 'window'], 'activity_snapshots_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method drops the 'activity_snapshots' table if the migration is rolled back.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_snapshots');
    }
};
