<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\CoreService\CoreException;
use App\CoreService\CoreService;


class FindUserById extends CoreService
{

    public $transaction = false;
    public $task = "super-admin";

    public function prepare($input)
    {
        return $input;
    }

    public function process($input, $originalInput)
    {
        $user = User::find($input["id"]);

        return $user;
    }

    protected function validation()
    {
        return [
            "limit" => "integer|min:0|max:1000",
            "offset" => "integer|min:0",
            "branch_id" => "integer"
        ];
    }
}
