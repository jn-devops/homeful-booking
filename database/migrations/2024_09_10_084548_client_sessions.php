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
        Schema::create('client_sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Session ID
            $table->string('user_id')->nullable(); // String-based user ID, can be null
            $table->string('ip_address', 45)->nullable(); // IP address, can handle both IPv4 and IPv6
            $table->text('user_agent')->nullable(); // Browser/Device information
            $table->text('payload'); // Session data
            $table->integer('last_activity'); // Last activity timestamp

            $table->timestamps(); // Optional: adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_sessions');
    }
};
