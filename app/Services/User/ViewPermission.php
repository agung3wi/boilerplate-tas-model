<?php

namespace App\Services\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\CoreService\CoreException;
use App\CoreService\CoreService;
use Illuminate\Support\Str;

class ViewPermission extends CoreService
{

    public $transaction = false;
    public $task = "super-admin";

    public function prepare($input)
    {
        $roleList = collect(DB::select("SELECT role_code FROM roles
        ORDER BY id ASC"));
        $input["roles"] = [];
        foreach ($roleList as $role) {
            $input["roles"][] = "cat_" . str_replace("-", "_", $role->role_code) . " text";
        }
        return $input;
    }

    public function process($input, $originalInput)
    {
        $roleList = implode(",", $input["roles"]);

        $sql = "WITH summary AS (
            SELECT *
                FROM
                crosstab('WITH summary_role_task AS (
                    SELECT A.id AS role_id, B.id AS task_id FROM roles A,tasks B
                )SELECT B.task_id, B.role_id, CASE WHEN A.task_id IS NULL THEN ''N'' ELSE ''Y'' END AS value FROM role_task A
                RIGHT JOIN summary_role_task B ON B.role_id = A.role_id AND B.task_id = A.task_id
                ORDER BY 1,2')
                AS role_task(task_id bigint, $roleList)
            ) SELECT B.task_name, A.* FROM summary A
            INNER JOIN tasks B ON A.task_id = B.id";

        Log::debug($sql);
        return DB::select($sql);
    }

    protected function validation()
    {
        return [];
    }
}
