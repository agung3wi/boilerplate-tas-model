<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CoreService\CoreResponse;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use App\CoreService\CoreException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class UploadController extends Controller
{
    public function upload()
    {
        // $req = request()->all();
        // $path = request()->file('file')->store('tmp');
        $file = request()->file('file');
        $originalname = $file->getClientOriginalName();

        if (Storage::exists("tmp/" . $originalname)) {
            $id = 1;
            $filename = pathinfo(storage_path("tmp/" . $originalname), PATHINFO_FILENAME);
            while (true) {
                $originalname = $filename . "($id)." . $file->getClientOriginalExtension();
                if (!Storage::exists("tmp/" . $originalname))
                    break;
                $id++;
            }
        }
        $path = $file->storeAs('tmp', $originalname);
        $result = [
            "path" => $path,
            "originalname" => $originalname
        ];
        return CoreResponse::ok($result);
    }

    public function getFile($model, $field, $id, $fileName)
    {
        $classModel = "\\App\\Models\\" . Str::upper(Str::camel($model));
        if (!class_exists($classModel))
            throw new CoreException("Not found", 404);

        if (!$classModel::FILEROOT)
            throw new CoreException("Not found", 404);

        $sql = "SELECT A." . $field . " FROM " . $classModel::TABLE . " A WHERE A.id = :id";
        $params = ["id" => $id];

        $fileName =  DB::selectOne($sql, $params)->$field;
        $path  = $classModel::FILEROOT . '/';
        $data = $path.$fileName;
        if (Storage::exists($data)) {
            return Storage::download($data);
            // return Storage::path($data);
        }else{
            return [
                "message" => "File Not Found"
            ];
        }
    }
}
