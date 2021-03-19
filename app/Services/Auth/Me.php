<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\CoreService\CoreException;
use App\CoreService\CoreService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Me extends CoreService
{

    public $transaction = false;
    public $task = null;

    public function prepare($input)
    {
        return $input;
    }

    public function process($input, $originalInput)
    {
        $user = Auth::user();
        if (is_null($user)) {
            throw new CoreException(__("message.403"), 403);
        }
        return $user;
    }

    protected function validation()
    {
        return [
            "aaa" => "integer"
        ];
    }
}
