<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\CoreService\CoreException;
use App\CoreService\CoreService;
use Illuminate\Support\Facades\URL;

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
        $user = User::select("users.*","roles.role_name")->leftjoin('roles', 'roles.id', 'users.role_id')->find($input["id"]);
        $fileUpload = ["img_photo_users"];
        if (!empty($user)) {
            $user->password = "";
            if (!empty($fileUpload))
                foreach ($fileUpload as $item) {
                    if ($user->$item) {
                        $url = URL::to('api/file/user/' . $item . '/' . $input["id"] . '/' . $user->$item);
                        $user->{$item} = (object)[
                            "url" => $url,
                            "filename" => $user->$item
                        ];
                    }
                }
        }
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
