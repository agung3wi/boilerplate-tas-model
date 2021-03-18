<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

if (!function_exists('hasPermission')) {
    function hasPermission($task)
    {
        $userId = Auth::id();
        $permission = DB::selectOne("SELECT 1 FROM users A
            INNER JOIN role_task B ON B.role_id = A.role_id
            INNER JOIN tasks C ON B.task_id = C.id AND C.task_code = ?
        WHERE A.id = ?", [$task, $userId]);

        return !is_null($permission);
    }
}
