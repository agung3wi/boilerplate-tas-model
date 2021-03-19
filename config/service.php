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
        "type" => "GET",
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
        "end_point" => "/user",
        "class" => "App\Services\User\GetUser"
    ],
    [
        "type" => "POST",
        "end_point" => "/user/add",
        "class" => "App\Services\User\AddUser"
    ],
    [
        "type" => "GET",
        "end_point" => "/login",
        "class" => "App\Services\Auth\DoLogin"
    ],
];
