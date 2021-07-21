<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_code', 255)->unique();
            $table->string('role_name', 255);
            $table->text('description');
            $table->timestampsTz($precision = 0);
        });
        DB::table("roles")->insert([
            "id" => -1,
            "role_code" => "super-admin",
            "role_name" => "Super Admin",
            "description" => "Super Admin"
        ]);

        DB::table("roles")->insert([
            "role_code" => "qhse-pusat",
            "role_name" => "QHSE PUSAT",
            "description" => "Level QHSE Pusat"
        ]);

        DB::table("roles")->insert([
            "role_code" => "qhse-dept",
            "role_name" => "QHSE DEPARTEMEN",
            "description" => "Level QHSE Departemen"
        ]);

        DB::table("roles")->insert([
            "role_code" => "qhse-project",
            "role_name" => "QHSE PROYEK",
            "description" => "Level QHSE Proyek"
        ]);

        DB::table("roles")->insert([
            "role_code" => "project-manager",
            "role_name" => "PROJECT MANAGER",
            "description" => "Level Project Manager"
        ]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
