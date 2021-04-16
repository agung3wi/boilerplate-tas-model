<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->nullable(false)->unique();
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
        Schema::dropIfExists('category_materials');
    }
}
