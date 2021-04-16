<?php

namespace App\Http\Controllers;

use App\CoreService\CallService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class CrudController extends Controller
{
    public function index($model)
    {
        $input = request()->all();
        $input["model"] = $model;
        return CallService::run("Get", $input);
    }

    public function show($model, $id)
    {
        $input = request()->all();
        $input["id"] = $id;
        $input["model"] = $model;
        return CallService::run("Find", $input);
    }

    public function create($model)
    {
        $input = request()->all();
        $input["model"] = $model;
        return CallService::run("Add", $input);
    }

    public function update($model)
    {
        $input = request()->all();
        $input["model"] = $model;
        return CallService::run("Edit", $input);
    }

    public function remove($model)
    {
        $classModel = "\\App\\Models\\" . Str::upper(Str::camel($model));
        if (!class_exists($classModel))
            return $this->notFound();
        if (!$classModel::REMOVE)
            return $this->notFound();

        if (!hasPermission("remove-" . $model)) {
            return $this->forbidden();
        }
        $id = request()->input("id");
        $product = $classModel::find($id);
        $product->active = 1;
        $product->save();

        return response()->json($product);
    }

    public function restore($model)
    {
        $classModel = "\\App\\Models\\" . Str::upper(Str::camel($model));
        if (!class_exists($classModel))
            return $this->notFound();

        if (!$classModel::RESTORE)
            return $this->notFound();

        if (!hasPermission("restore-" . $model)) {
            return $this->forbidden();
        }
        $id = request()->input("id");
        $product = $classModel::find($id);
        $product->active = 0;
        $product->save();

        return response()->json($product);
    }

    public function delete($model)
    {
        $input = request()->all();
        $input["model"] = $model;
        return CallService::run("Delete", $input);
    }

    private function forbidden()
    {
        return response()->json([
            "message" => __("message.403")
        ], 403);
    }

    private function notFound()
    {
        return response()->json([
            "message" => __("message.404")
        ], 404);
    }

    public function generate($model) {
        $classModel = "\\App\\Models\\" . Str::upper(Str::camel($model));
        $fieldLeanguage = [];
        foreach ($classModel::FIELD_LIST as $list) {
            
        }
        return [
            "table" => $classModel::TABLE,
            "lableTable" => [
                "ID" => "Daftar Pekerja",
                "EN" => "Worker List"
            ],                                        
            "primaryKey" => "id",                                        
            "isList" => $classModel::IS_LIST,
            "isView" => $classModel::IS_VIEW,
            "isEdit" => $classModel::IS_EDIT,
            "isAdd" => $classModel::IS_ADD,
            "isDelete" => $classModel::IS_DELETE,
            "fieldList" => $classModel::FIELD_LIST,
            "fieldView" => $classModel::FIELD_VIEW,
            "fieldEdit" => $classModel::FIELD_EDIT,
            "fieldAdd" => $classModel::FIELD_ADD,
            "fieldReadonly" => $classModel::FIELD_READONLY,                      
            "fieldFilterable" => $classModel::FIELD_FILTERABLE,
            "fieldSearchable" => $classModel::FIELD_SEARCHABLE,
            "fieldType" => $classModel::FIELD_TYPE,
            "fieldRelation" => $classModel::FIELD_RELATION,
            "fieldValidation" => $classModel::FIELD_VALIDATION,
            "parentChild" => $classModel::PARENT_CHILD,
            "fieldLanguage" => [
                "ID" => [
                    "name" => "Nama Pekerja",
                    "department_id" => "Nama Departemen",
                    "project_id" => "Nama Project",
                    "type_worker_id" => "Jenis Pekerja",
                    "expertise_id" => "Keahlian"
                ],
                "EN" => [
                    "name" => "Worker Name",
                    "department_id" => "Department Name",
                    "project_id" => "Project Name",
                    "type_worker_id" => "Worker Type",
                    "expertise_id" => "Expertise"
                ]
            ] 
        ];
    }

    
}
