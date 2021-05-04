<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\CoreService\CoreException;
use App\CoreService\CoreService;
use Illuminate\Support\Facades\Storage;


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
        $user->fullname = $input["fullname"];
        $user->role_id = $input["role_id"];
        $user->img_photo_users = $input["img_photo_users"];
        $user->created_at = $input["session"]["datetime"];
        $user->updated_at = $input["session"]["datetime"];
        $user->active = $input["active"];
        $user->save();

        // MOVE FILE
        $fieldUpload = ["img_photo_users"];
        foreach ($fieldUpload as $item) {
            $tmpName = $input[$item] ?? null;

            if (!is_null($tmpName)) {
                $tmpPath = "tmp/".$tmpName;
                $newPath = "user/" . $input[$item];
                //START MOVE FILE
                if (Storage::exists($newPath)) {
                    $id = 1;
                    $filename = pathinfo(storage_path($newPath), PATHINFO_FILENAME);
                    $ext = pathinfo(storage_path($newPath), PATHINFO_EXTENSION);
                    while (true) {
                        $originalname = $filename . "($id)." . $ext;
                        if (!Storage::exists("user/" . $originalname))
                            break;
                        $id++;
                    }
                    $newPath = "user/" . $originalname;
                    $user->{$item} = $originalname;
                }

                Storage::move($tmpPath, $newPath);
                //END MOVE FILE
            }
        }
        // END MOVE FILE

        return [
            "data" => $user,
            "message" => "Data Berhasil Disimpan"
        ];
    }

    protected function validation()
    {
        return [
            "username" => "required|max:25",
            "password" => "required",
            "email" => "email|nullable",
            "fullname" => "required",
            "role_id" => "required"
        ];
    }
}
