<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\CoreService\CoreException;
use App\CoreService\CoreService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DoLogin extends CoreService
{

    public $transaction = false;
    public $task = null;

    public function prepare($input)
    {
        return $input;
    }

    public function process($input, $originalInput)
    {
        $credentials = [
            "email" => $input["email"],
            "password" => $input["password"]
        ];

        if (Auth::attempt($credentials)) {
            $user = User::where("email", $input["email"])->first();
            Auth::loginUsingId($user->id);
            return [
                "user" => $user,
                "message" => __("message.loginSuccess")
            ];
        } else {
            return [
                "message" => __("message.loginFailed")
            ];
        }
    }

    protected function validation()
    {
        return [
            "aaa" => "integer"
        ];
    }
}
