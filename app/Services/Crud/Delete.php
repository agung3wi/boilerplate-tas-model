<?php

namespace App\Services\Crud;

use App\CoreService\CoreException;
use App\CoreService\CoreService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Delete extends CoreService
{

    public $transaction = true;
    public $task = null;

    public function prepare($input)
    {
        $model = $input["model"];
        $classModel = "\\App\\Models\\" . Str::upper(Str::camel($model));
        if (!class_exists($classModel))
            throw New CoreException("Not found", 404);

        if (!$classModel::IS_DELETE)
            throw New CoreException("Not found", 404);

        if (!hasPermission("delete-" . $model))
            throw New CoreException("Forbidden", 403);
        $input["class_model"] = $classModel;
        return $input;
    }

    public function process($input, $originalInput)
    {
        $classModel = $input["class_model"];     
        $rules = ["id" => "required|integer" ]; 

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            throw new CoreException($validator->errors()->first());
        }

        $object = $classModel::find($input["id"]);
        $object->delete();

        return [
            "message" => __("message.successfullyDelete")
        ];
    }

    protected function validation()
    {
        return [];
    }
}
