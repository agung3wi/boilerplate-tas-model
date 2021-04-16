<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plants_id')->nullable(true);
            $table->string('name', 255)->nullable(false)->unique();
            $table->text('address')->nullable(true);
            $table->text('singlef_photo')->nullable(true);
            $table->text('latitude')->nullable(true);
            $table->text('longitude')->nullable(true);
            $table->integer('active')->nullable(true)->default('1');
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
        Schema::dropIfExists('projects');
    }
}
