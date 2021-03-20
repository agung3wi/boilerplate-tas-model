<?php

namespace App\Services\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\CoreService\CoreException;
use App\CoreService\CoreService;


class SavePermission extends CoreService
{

    public $transaction = true;
    public $task = "super-admin";

    public function prepare($input)
    {
        $roleList = collect(DB::select("SELECT id, role_code FROM roles
        ORDER BY id ASC"));
        $input["roles"] = [];
        foreach ($roleList as $role) {
            $input["roles"]["cat_" . str_replace("-", "_", $role->role_code)] = $role->id;
        }
        return $input;
    }

    public function process($input, $originalInput)
    {
        $permissionInput = [];
        foreach ($input["permissions"] as $permission) {
            foreach ($permission as $key => $value) {
                if (substr($key, 0, 3) == "cat" && $value == "Y") {
                    $permissionInput[] = [
                        "task_id" => $permission["task_id"],
                        "role_id" =>  $input["roles"][$key]
                    ];
                }
            }
        }


        DB::select("TRUNCATE TABLE role_task");
        DB::table("role_task")->insert($permissionInput);
        return [
            "message" => "Berhasil"
        ];
    }

    protected function validation()
    {
        return [];
    }
}
