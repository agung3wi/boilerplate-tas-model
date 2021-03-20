<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\CoreService\CoreException;
use App\CoreService\CoreService;


class RemoveUser extends CoreService
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

        $input["user"]->active = "N";
        $input["user"]->updated_at = $input["session"]["datetime"];
        $input["user"]->save();

        return $input["user"];
    }

    protected function validation()
    {
        return [
            "id" => "required|integer"
        ];
    }
}
