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
        return $input;
    }

    public function process($input, $originalInput)
    {
        $condition = "WHERE true";
        $params = [];
        if (!is_null($input["src"] ?? null)) {
            $condition .= " AND (
                UPPER(task_code) LIKE ?
                OR UPPER(task_name) LIKE ?
                OR UPPER(description) LIKE ?
            )";
            $params[] = "%" . $input["src"] . "%";
            $params[] = "%" . $input["src"] . "%";
            $params[] = "%" . $input["src"] . "%";
        }

        $tasks = DB::select("SELECT * FROM tasks $condition", $params);
        $roles = DB::select("SELECT * FROM roles");
        $roleTaskList = [];
        foreach (DB::select("SELECT * FROM role_task") as $roleTask) {
            $roleTaskList[$roleTask->role_id][$roleTask->task_id] = true;
        }
        $result = [];
        $i = 0;
        foreach ($tasks as $task) {
            $result[$i] = [
                "task_id" => $task->id,
                "task_code" => $task->task_code,
                "task_name" => $task->task_name
            ];
            foreach ($roles as $role) {
                $result[$i][$role->role_code] =
                    isset($roleTaskList[$role->id][$task->id]) ? "Y" : "N";
            }
            $i++;
        }

        return $result;
    }

    protected function validation()
    {
        return [];
    }
}
