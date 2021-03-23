<?php

return [
    [
        "type" => "GET",
        "end_point" => "/sample",
        "class" => "App\Services\Sample\SampleService"
    ],
    [
        "type" => "GET",
        "end_point" => "/me",
        "class" => "App\Services\Auth\Me"
    ],
    [
        "type" => "GET",
        "end_point" => "/logout",
        "class" => "App\Services\Auth\DoLogout"
    ],
    [
        "type" => "POST",
        "end_point" => "/login",
        "class" => "App\Services\Auth\DoLogin"
    ],
    [
        "type" => "GET",
        "end_point" => "/role",
        "class" => "App\Services\User\GetRole"
    ],
    [
        "type" => "GET",
        "end_point" => "/user/find",
        "class" => "App\Services\User\FinduserById"
    ],
    [
        "type" => "GET",
        "end_point" => "/user",
        "class" => "App\Services\User\GetUser"
    ],
    [
        "type" => "POST",
        "end_point" => "/user/add",
        "class" => "App\Services\User\AddUser"
    ],
    [
        "type" => "POST",
        "end_point" => "/user/edit",
        "class" => "App\Services\User\EditUser"
    ],
    [
        "type" => "POST",
        "end_point" => "/user/remove",
        "class" => "App\Services\User\RemoveUser"
    ],
    [
        "type" => "POST",
        "end_point" => "/user/restore",
        "class" => "App\Services\User\RestoreUser"
    ],
    [
        "type" => "POST",
        "end_point" => "/reset-password",
        "class" => "App\Services\User\ResetPassword"
    ],
    [
        "type" => "GET",
        "end_point" => "/permission",
        "class" => "App\Services\User\ViewPermission"
    ],
    [
        "type" => "POST",
        "end_point" => "/permission/save",
        "class" => "App\Services\User\SavePermission"
    ],
    [
        "type" => "POST",
        "end_point" => "/role/add",
        "class" => "App\Services\User\AddRole"
    ],
    [
        "type" => "POST",
        "end_point" => "/role/edit",
        "class" => "App\Services\User\EditRole"
    ],
    [
        "type" => "GET",
        "end_point" => "/role/find",
        "class" => "App\Services\User\FindRoleById"
    ],
];
