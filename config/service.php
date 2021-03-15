<?php


return [
    [
        "type" => "GET",
        "end_point" => "/sample",
        "class" => "App\Services\Sample\SampleService"
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
];
