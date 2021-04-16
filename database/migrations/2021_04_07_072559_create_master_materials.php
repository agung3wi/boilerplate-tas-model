<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category_materials_id', 255)->nullable(false);
            $table->string('name', 255)->nullable(false)->unique();
            $table->string('uom', 255)->nullable(false)->unique();
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
        Schema::dropIfExists('master_materials');
    }
}
