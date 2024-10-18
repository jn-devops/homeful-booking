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
        Schema::table('users', function (Blueprint $table) {
            // Reverse the changes in the 'imports' table
            Schema::table('imports', function (Blueprint $table) {
//                $table->dropForeign(['user_id']);
                $table->unsignedBigInteger('user_id')->change();
            });

            // Reverse the changes in the 'exports' table
            Schema::table('exports', function (Blueprint $table) {
//                $table->dropForeign(['user_id']);
                $table->unsignedBigInteger('user_id')->change();
            });

            // Reverse the 'users' table change
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('id')->change();
            });

            // Recreate the foreign key constraint on 'imports'
            Schema::table('imports', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });

            // Recreate the foreign key constraint on 'exports'
            Schema::table('exports', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
