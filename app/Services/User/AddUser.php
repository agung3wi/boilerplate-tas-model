<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\CoreService\CoreException;
use App\CoreService\CoreService;


class AddUser extends CoreService
{

    public $transaction = true;
    public $task = 'super-admin';

    public function prepare($input)
    {
        $usernameExists = DB::selectOne("SELECT 1 FROM users WHERE username = :username", ["username" => $input["username"]]);
        if (!is_null($usernameExists)) {
            throw new CoreException("User dengan username " . $input["username"] . " sudah ada");
        }

        return $input;
    }

    public function process($input, $originalInput)
    {
        $user = new User;
        $user->username = $input["username"];
        $user->password = password_hash($input["password"], PASSWORD_BCRYPT);
        $user->email = isset($input["email"]) ? $input["email"] : "";
        $user->name = $input["name"];
        $user->role_id = $input["role_id"];
        $user->created_at = $input["session"]["datetime"];
        $user->updated_at = $input["session"]["datetime"];
        $user->save();

        return $user;
    }

    protected function validation()
    {
        return [
            "username" => "required|max:25",
            "password" => "required",
            "email" => "email|nullable",
            "name" => "required"
        ];
    }
}
