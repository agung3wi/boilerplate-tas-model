<?php

namespace App\Services\Crud;

use App\CoreService\CoreException;
use App\CoreService\CoreService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Add extends CoreService
{

    public $transaction = true;
    public $task = null;

    public function prepare($input)
    {
        $model = $input["model"];
        $classModel = "\\App\\Models\\" . Str::upper(Str::camel($model));
        if (!class_exists($classModel))
            throw new CoreException("Not found", 404);

        if (!$classModel::IS_ADD)
            throw new CoreException("Not found", 404);

        if (!hasPermission("add-" . $model))
            throw new CoreException("Forbidden", 403);
        $input["class_model"] = $classModel;

        $validator = Validator::make($input, $classModel::FIELD_VALIDATION);

        if ($validator->fails()) {
            throw new CoreException($validator->errors()->first());
        }

        if ($classModel::FIELD_UNIQUE) {
            foreach ($classModel::FIELD_UNIQUE as $search) {
                $query = $classModel::whereRaw("true");
                $fieldTrans = [];
                foreach ($search as $key) {
                    $fieldTrans[] = __("field.$key");
                    $query->where($key, $input[$key]);
                };
                $isi = $query->first();
                if (!is_null($isi)) {
                    throw new CoreException(__("message.alreadyExist", ['field' => implode(",", $fieldTrans)]));
                }
            }
        }
        return $input;
    }

    public function process($input, $originalInput)
    {
        $classModel = $input["class_model"];


        $input = $classModel::beforeInsert($input);

        $object = new $classModel;
        foreach ($classModel::FIELD_ADD as $item) {
            if ($item == "created_by") {
                $input[$item] = Auth::id();
            }
            if ($item == "updated_by") {
                $input[$item] = Auth::id();
            }
            $object->{$item} = $input[$item] ?? $classModel::FIELD_DEFAULT_VALUE[$item];
        }

        // MOVE FILE
        foreach ($classModel::FIELD_UPLOAD as $item) {
            $tmpName = $input[$item] ?? null;

            if (!is_null($tmpName)) {
                $tmpPath = "tmp/".$tmpName;
                $newPath = $classModel::FILEROOT . "/" . $input[$item];
                //START MOVE FILE
                if (Storage::exists($newPath)) {
                    $id = 1;
                    $filename = pathinfo(storage_path($newPath), PATHINFO_FILENAME);
                    $ext = pathinfo(storage_path($newPath), PATHINFO_EXTENSION);
                    while (true) {
                        $originalname = $filename . "($id)." . $ext;
                        if (!Storage::exists($classModel::FILEROOT . "/" . $originalname))
                            break;
                        $id++;
                    }
                    $newPath = $classModel::FILEROOT . "/" . $originalname;
                    $object->{$item} = $originalname;
                }

                Storage::move($tmpPath, $newPath);
                //END MOVE FILE
            }
        }
        // END MOVE FILE

        $object->save();

        $classModel::afterInsert($object, $input);

        return [
            "data" =>$object,
            "message" => __("message.successfullyAdd")
        ];
    }

    protected function validation()
    {
        return [];
    }
}
