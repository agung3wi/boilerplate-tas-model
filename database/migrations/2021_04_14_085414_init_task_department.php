<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InitTaskDepartment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table("tasks")->insert([
            "task_code" => "view-department",
            "task_name" => "View Department",
            "task_group" => "department",
            "description" => "View Department"
        ]);
        DB::table("tasks")->insert([
            "task_code" => "add-department",
            "task_name" => "Add Department",
            "task_group" => "department",
            "description" => "Add Department"
        ]);
        DB::table("tasks")->insert([
            "task_code" => "edit-department",
            "task_name" => "Edit Department",
            "task_group" => "department",
            "description" => "Edit Department"
        ]);
        DB::table("tasks")->insert([
            "task_code" => "delete-department",
            "task_name" => "Delete Department",
            "task_group" => "department",
            "description" => "Delete Department"
        ]);
        DB::table("tasks")->insert([
            "task_code" => "remove-department",
            "task_name" => "Remove Department",
            "task_group" => "department",
            "description" => "Remove Department"
        ]);
        DB::table("tasks")->insert([
            "task_code" => "restore-department",
            "task_name" => "Restore Department",
            "task_group" => "department",
            "description" => "Restore Department"
        ]);
        DB::statement("INSERT INTO role_task(role_id, task_id) SELECT -1, id FROM tasks WHERE task_group = 'department'");

        
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
