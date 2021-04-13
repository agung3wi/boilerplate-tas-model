<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_name', 100);
            $table->bigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('m_department');
            $table->text('description');
            $table->string('project_img', 255);
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('m_project');
    }
}
