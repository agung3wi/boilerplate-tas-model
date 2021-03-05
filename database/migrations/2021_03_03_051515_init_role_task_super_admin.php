<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InitRoleTaskSuperAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table("tasks")->insert([
            "id" => -1,
            "task_code" => "super-admin",
            "task_name" => "Super Admin",
            "description" => "Super Admin"
        ]);

        DB::table("tasks")->insert([
            "id" => -2,
            "task_code" => "user",
            "task_name" => "User",
            "description" => "User"
        ]);

        DB::table("role_task")->insert([
            "task_id" => -1,
            "role_id" => -1
        ]);

        DB::statement("INSERT INTO role_task(role_id,task_id)
            SELECT id AS role_id, -2 AS task_id FROM roles");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
