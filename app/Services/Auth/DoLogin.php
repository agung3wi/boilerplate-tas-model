<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\CoreService\CoreException;
use App\CoreService\CoreService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

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
            "username" => $input["username"],
            "password" => $input["password"]
        ];

        $user = User::select("users.*", "roles.role_name")->leftjoin('roles', 'roles.id', 'users.role_id')->where("username", $input["username"])->first();
        if (empty($user))
            throw new CoreException(__("message.userNotFound", ['username' => $input["username"]]), 422);

        if (Config::get("auth.defaults.guard") == "web") {
            if ($token = !Auth::attempt($credentials)) {
                throw new CoreException(__("message.loginCredentialFalse"), 401);
            }
            Auth::loginUsingId($user->id);
            $token = null;
        } else {
            if ($token = Auth::attempt($credentials)) {
            } else {
                throw new CoreException(__("message.loginCredentialFalse"), 401);
            }
        }

        if ($user->status_code == 'email_unverified')
            throw new CoreException(__("message.userEmailNotVerifiedYet", ['email' => $user->email]), 422);
        if ($user->status_code == 'email_verified')
            throw new CoreException(__("message.userEmailVerifiedWaitingApproval", ['username' => $input["username"]]), 422);
        if ($user->status_code == 'user_rejected')
            throw new CoreException(__("message.userRejectedByAdmin", ['username' => $input["username"]]), 422);
        if ($user->status_code == 'user_nonactive')
            throw new CoreException(__("message.userNotActive", ['username' => $input["username"]]), 422);


        $sql = "SELECT B.task_code FROM role_task A
            INNER JOIN tasks B ON B.id = A.task_id
            INNER JOIN users C ON C.role_id = A.role_id AND C.id = ?";

        $permissionList =  array_map(function ($item) {
            return $item->task_code;
        }, DB::select($sql, [$user->id]));

        $fileUpload = ["img_photo_user"];
        if (!empty($user)) {
            $user->password = "";
            if (!empty($fileUpload))

                foreach ($fileUpload as $item) {

                    if ($user->$item) {
                        $url = URL::to('api/file/users/' . $item . '/' . $user->id . '/' . $user->$item);
                        $ext = pathinfo($url, PATHINFO_EXTENSION);
                        $user->{$item} = (object)[
                            "ext" => $ext,
                            "url" => $url,
                            "filename" => $user->$item
                        ];
                    }
                }
        }

        // array_map(function ($key) use ($classModelUser) {
        //     foreach ($key as $field => $value) {
        //         if (preg_match("/file_/i", $field) or preg_match("/img_/i", $field)) {
        //             $url = URL::to('api/file/' . $classModelUser::TABLE . '/' . $field . '/' . $key->id . '/' . $key->$field);
        //             $ext = pathinfo($url, PATHINFO_EXTENSION);
        //             $key->$field = (object) [
        //                 "ext" => $ext,
        //                 "url" => $url,
        //                 "filename" => $key->$field
        //             ];
        //         }
        //     }
        //     return $key;
        // }, $user);
        return [
            "user" => $user,
            "token" => $token,
            "tasks" => $permissionList,
            "message" => __("message.loginSuccess")
        ];
    }

    protected function validation()
    {
        return [
            "username" => "required",
            "password" => "required"
        ];
    }
}
