<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plants_id')->nullable(true);
            $table->bigInteger('year')->nullable(true);
            $table->bigInteger('months_id')->nullable(true);
            $table->bigInteger('consumers_id')->nullable(true);
            $table->bigInteger('materials_id')->nullable(true);
            $table->float('volume', 65, 2);
            $table->bigInteger('created_by')->nullable(true);
            $table->bigInteger('updated_by')->nullable(true);
            $table->timestampsTz($precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_plans');
    }
}
