<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname');
            $table->string('username')->unique();
            $table->text('password');
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->text('img_photo_user')->nullable();
            $table->foreignId('role_id')->constrained('roles');
            $table->string('job_position')->nullable();
            $table->timestampTz('email_verified_at')->nullable();
            $table->string('status_code');
            $table->timestampTz('approval_at')->nullable();
            $table->foreignId('approval_by')->nullable()->constrained('users');
            $table->string('api_token')->nullable(true);
            $table->timestampsTz($precision = 0);
        });

        $role = DB::selectOne("SELECT id FROM roles WHERE role_code = 'super-admin'");
        DB::table("users")->insert([
            "fullname" => "Super Admin",
            "username" => "admin",
            "password" => bcrypt("admin"),
            "role_id" => $role->id,
            "status_code" => 'user_active'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
