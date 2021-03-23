<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_product', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("code", 100)->unique();
            $table->string("name", 100);
            $table->decimal("default_price");
            $table->string("uom_name", 100);
            $table->bigInteger("created_by");
            $table->bigInteger("updated_by");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_m_product');
    }
}
