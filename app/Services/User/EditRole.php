<?php

namespace App\Services\User;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use App\CoreService\CoreException;
use App\CoreService\CoreService;


class EditRole extends CoreService
{

    public $transaction = true;
    public $task = 'super-admin';

    public function prepare($input)
    {
        $input["role"] = Role::find($input["id"]);
        if (is_null($input["role"])) {
            throw new CoreException("Role dengan id " . $input["id"] . " tidak ditemukan");
        }

        return $input;
    }

    public function process($input, $originalInput)
    {
        $role = $input["role"];
        $role->role_name = $input["role_name"];
        $role->description = isset($input["description"]) ? $input["description"] : "";
        $role->created_at = $input["session"]["datetime"];
        $role->updated_at = $input["session"]["datetime"];
        $role->save();

        return $role;
    }

    protected function validation()
    {
        return [
            "id" => "required|integer",
            "role_code" => "required|max:25",
            "role_name" => "required"
        ];
    }
}
