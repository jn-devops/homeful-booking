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
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['notifiable_id', 'notifiable_type']);

            // Add the new UUID morph columns
            $table->uuidMorphs('notifiable');
//            $table->string('notifiable_id', 36)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Rollback: drop UUID morph columns
            $table->dropColumn(['notifiable_id', 'notifiable_type']);

            // Add back the original integer morph columns
            $table->morphs('notifiable');
        });
    }
};
