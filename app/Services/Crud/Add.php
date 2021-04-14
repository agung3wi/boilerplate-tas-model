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

        if (!$classModel::GET)
            throw New CoreException("Not found", 404);

        // if (!hasPermission("add-" . $model))
        //     throw New CoreException("Forbidden", 403);
        $input["class_model"] = $classModel;
        return $input;
    }

    public function process($input, $originalInput)
    {
        $classModel = $input["class_model"];        

        $validation = [];

        foreach ($classModel::FIELDS as $item => $value) {
            $validation[$item] = $value["validation_add"] ?? "";
        }

        $validator = Validator::make(request()->all(), $validation);

        if ($validator->fails()) {
            throw new CoreException($validator->errors()->first());
        }

        $input = $classModel::beforeInsert(request()->all());

        $inputOnly = [];
        foreach ($classModel::FIELDS as $item => $value) {
            $inputOnly[$item] = ($value["add"]) ? $input[$item] : $value["default"];
        }

        $inputOnly["created_by"] = -1;
        $inputOnly["updated_by"] = -1;


        $product =  $classModel::create($inputOnly);
        $classModel::afterInsert($product, $input);

        return $product;
    }

    protected function validation()
    {
        return [];
    }
}
