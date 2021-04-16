<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCutOffPeriod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cut_off_period', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('year')->nullable(false);
            $table->integer('months_id')->nullable(false);
            $table->date('start_date')->nullable(false);
            $table->date('end_date')->nullable(false);
            $table->bigInteger('created_by')->nullable(true);
            $table->bigInteger('updated_by')->nullable(true);
            $table->timestampsTz($precision = 0);

            $table->unique(array('year', 'months_id'));

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cut_off_period');
    }
}
