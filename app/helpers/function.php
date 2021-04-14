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

if (!function_exists('is_blank')) {

    function is_blank($array, $key)
    {
        return isset($array[$key]) ? (empty($array[$key]) ? true : false) : true;
    }
}

if (!function_exists('toAlpha')) {

    function toAlpha($data)
    {
        $alphabet =   array(
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
        );
        return $alphabet[$data];
    }
}
