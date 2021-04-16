<?php

namespace App\Services\Crud;

use App\CoreService\CoreException;
use App\CoreService\CoreService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Add extends CoreService
{

    public $transaction = true;
    public $task = null;

    public function prepare($input)
    {
        $model = $input["model"];
        $classModel = "\\App\\Models\\" . Str::upper(Str::camel($model));
        if (!class_exists($classModel))
            throw New CoreException("Not found", 404);

        if (!$classModel::IS_ADD)
            throw New CoreException("Not found", 404);

        if (!hasPermission("add-" . $model))
            throw New CoreException("Forbidden", 403);
        $input["class_model"] = $classModel;
        return $input;
    }

    public function process($input, $originalInput)
    {
        $classModel = $input["class_model"];        

        $validator = Validator::make($input, $classModel::FIELD_VALIDATION);

        if ($validator->fails()) {
            throw new CoreException($validator->errors()->first());
        }

        $input = $classModel::beforeInsert($input);

        $object = new $classModel;
        foreach ($classModel::FIELD_ADD as $item) {
            if($item == "created_by") {
                $input[$item] = Auth::id();
            }
            if($item == "updated_by") {
                $input[$item] = Auth::id();
            }
            $object->{$item} = $input[$item];
        }

        $object->save();
        $classModel::afterInsert($object, $input);

        return $object;
    }

    protected function validation()
    {
        return [];
    }
}
