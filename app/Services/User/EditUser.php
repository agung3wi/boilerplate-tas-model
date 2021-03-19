<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\CoreService\CoreException;
use App\CoreService\CoreService;


class EditUser extends CoreService
{

    public $transaction = true;
    public $task = 'super-admin';

    public function prepare($input)
    {
        $user = User::find($input["id"]);
        if (is_null($user)) {
            throw new CoreException("Pengguna tidak ditemukan");
        }

        $input["user"] = $user;
        return $input;
    }

    public function process($input, $originalInput)
    {

        $input["user"]->email = isset($input["email"]) ? $input["email"] : "";
        $input["user"]->name = $input["name"];
        $input["user"]->updated_at = $input["session"]["datetime"];
        $input["user"]->save();

        return $input["user"];
    }

    protected function validation()
    {
        return [
            "email" => "email|nullable",
            "name" => "required"
        ];
    }
}
