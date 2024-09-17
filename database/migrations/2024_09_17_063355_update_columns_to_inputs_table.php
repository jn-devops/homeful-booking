<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Homeful\Common\Classes\Input;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('inputs');
        Schema::create('inputs', function (Blueprint $table) {
            $table->id();
            $table->string(Input::SKU);
            $table->float(Input::WAGES);
            $table->float(Input::TCP);
            $table->float(Input::PERCENT_DP);
            $table->float(Input::PERCENT_MF);
            $table->integer(Input::DP_TERM);
            $table->integer(Input::BP_TERM);
            $table->float(Input::BP_INTEREST_RATE);
            $table->string(Input::SELLER_COMMISSION_CODE);
            $table->string(Input::PROMO_CODE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inputs', function (Blueprint $table) {
            //
        });
    }
};
