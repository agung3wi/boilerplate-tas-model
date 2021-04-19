<?php

namespace App\Services\Crud;

use App\CoreService\CoreException;
use App\CoreService\CoreService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Edit extends CoreService
{

    public $transaction = true;
    public $task = null;

    public function prepare($input)
    {
        $model = $input["model"];
        $classModel = "\\App\\Models\\" . Str::upper(Str::camel($model));
        if (!class_exists($classModel))
            throw New CoreException("Not found", 404);

        if (!$classModel::IS_EDIT)
            throw New CoreException("Not found", 404);

        if (!hasPermission("edit-" . $model))
            throw New CoreException("Forbidden", 403);
        $input["class_model"] = $classModel;
        return $input;
    }

    public function process($input, $originalInput)
    {
        $classModel = $input["class_model"];       
        $rules = $classModel::FIELD_VALIDATION;
        $rules["id"] = "required|integer"; 

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            throw new CoreException($validator->errors()->first());
        }

        ///
        $validator = Validator::make($input, $classModel::FIELD_VALIDATION);

        if ($validator->fails()) {
            throw new CoreException($validator->errors()->first());
        }

        $object = $classModel::find($input["id"]);

        if ($classModel::FIELD_UNIQUE) {
            foreach ($classModel::FIELD_UNIQUE as $search) {
                $query = $classModel::whereRaw("true");
                $fieldTrans = [];
                $uniqueChange = false;
                foreach ($search as $key) {
                    if($input[$key] != $object->{$key}) {
                        $uniqueChange = true;
                    }
                    $fieldTrans[] = __("field.$key");
                    $query->where($key, $input[$key]);
                };

                if($uniqueChange) {
                    $isi = $query->first();
                    if (!is_null($isi)) {
                        throw new CoreException(__("message.alreadyExist", [ 'field' => implode(",",$fieldTrans)]));
                    }
                }
            }
        }
        //

        $input = $classModel::beforeUpdate($input);

        
        foreach ($classModel::FIELD_EDIT as $item) {
            if($item == "updated_by") {
                $input[$item] = Auth::id();
            }
            $object->{$item} = $input[$item];
        }

        $object->save();
        $classModel::afterUpdate($object, $input);

        return $object;
    }

    protected function validation()
    {
        return [];
    }
}
