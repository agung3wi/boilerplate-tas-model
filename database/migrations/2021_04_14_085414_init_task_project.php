<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InitTaskProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table("tasks")->insert([
            "task_code" => "view-project",
            "task_name" => "View Project",
            "task_group" => "project",
            "description" => "View Project"
        ]);
        DB::table("tasks")->insert([
            "task_code" => "add-project",
            "task_name" => "Add Project",
            "task_group" => "project",
            "description" => "Add Project"
        ]);
        DB::table("tasks")->insert([
            "task_code" => "edit-project",
            "task_name" => "Edit Project",
            "task_group" => "project",
            "description" => "Edit Project"
        ]);
        DB::table("tasks")->insert([
            "task_code" => "delete-project",
            "task_name" => "Delete Project",
            "task_group" => "project",
            "description" => "Delete Project"
        ]);
        DB::table("tasks")->insert([
            "task_code" => "remove-project",
            "task_name" => "Remove Project",
            "task_group" => "project",
            "description" => "Remove Project"
        ]);
        DB::table("tasks")->insert([
            "task_code" => "restore-project",
            "task_name" => "Restore Project",
            "task_group" => "project",
            "description" => "Restore Project"
        ]);
        DB::statement("INSERT INTO role_task(role_id, task_id) SELECT -1, id FROM tasks WHERE task_group = 'project'");

        
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
