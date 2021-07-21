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
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('territory_id')->constrained('territorys');
            $table->string('project_number', 255)->nullable(false)->unique();
            $table->string('project_name', 255)->nullable(false);
            $table->text('address')->nullable(true);
            $table->text('img_photo')->nullable(true);
            $table->text('latitude')->nullable(true);
            $table->text('longitude')->nullable(true);
            $table->date('start_date')->nullable(true);
            $table->date('end_date')->nullable(true);
            $table->string('project_manager', 255)->nullable(true);
            $table->string('qhse_officer', 255)->nullable(true);
            $table->text('array_contact_pic')->nullable(true);
            $table->integer('active')->nullable(true)->default('1');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestampsTz($precision = 0);
            
            $table->unique(array('department_id','territory_id', 'project_number'));
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
