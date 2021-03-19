<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InitUserAndAddRoleId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE users ADD COLUMN role_id bigint DEFAULT 1");
        DB::table("roles")->insert([
            "id" => -1,
            "role_code" => "super-admin",
            "role_name" => "Super Admin",
            "description" => "Super Admin"
        ]);

        DB::table("roles")->insert([
            "role_code" => "user",
            "role_name" => "User",
            "description" => "User"
        ]);

        DB::table("users")->insert([
            "name" => "Super Admin",
            "username" => "superadmin",
            "password" => bcrypt("plamongan17"),
            "role_id" => -1
        ]);
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
