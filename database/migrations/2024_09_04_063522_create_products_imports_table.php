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
        Schema::create('products_imports', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('project_location')->nullable();
            $table->string('project_code')->nullable();
            $table->string('property_name')->nullable();
            $table->string('phase')->nullable();
            $table->string('block')->nullable();
            $table->string('lot')->nullable();
            $table->string('lot_area')->nullable();
            $table->string('floor_area')->nullable();
            $table->string('project_address')->nullable();
            $table->string('property_type')->nullable();
            $table->string('unit_type')->nullable();
            $table->string('unit_type_interior')->nullable();
            $table->string('house_color')->nullable();
            $table->string('building')->nullable();
            $table->decimal('processing_fee', 10, 2)->nullable();
            $table->string('brand')->nullable();
            $table->string('sku')->nullable();
            $table->string('name')->nullable();
            $table->decimal('price', 15, 2);
            $table->string('market_segment')->nullable();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->text('product_location_details')->nullable();
            $table->text('lifestyle_destinations')->nullable();
            $table->text('amenities')->nullable();
            $table->text('how_to_get_there')->nullable();
            $table->decimal('appraised_value', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_imports');
    }
};
