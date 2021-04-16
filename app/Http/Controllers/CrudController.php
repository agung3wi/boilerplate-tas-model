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
        $classModel = "\\App\\Models\\" . Str::upper(Str::camel($model));
        if (!class_exists($classModel))
            return $this->notFound();
        if (!$classModel::FIND)
            return $this->notFound();
        if (!hasPermission("view-" . $model))
            return $this->forbidden();

        $selectableList = ["A." . ($classModel::PRIMARY_KEY ?? "id")];
        $tableJoinList = [];

        $i = 0;
        foreach ($classModel::FIELDS as $item => $value) {
            if ($value["find"]) {
                $selectableList[] = "A." . $item;
            }

            if (isset($value["relation"])) {
                $alias = $this->toAlpha($i + 1);
                $selectableList = array_merge($selectableList, array_map(function ($item) use ($alias) {
                    return $alias . "." . $item;
                }, $value["relation"]["selectable"]));

                $tableJoinList[] = "LEFT JOIN " . $value["relation"]["table"] . " " . $alias . " ON " .
                    "A." . $item . " = " .  $alias . "." . $value["relation"]["field_reference"];
            }
            $i++;
        }

        $condition = " WHERE A." . ($classModel::PRIMARY_KEY ?? "id") . " = :id";

        $sql = "SELECT " . implode(", ", $selectableList) . " FROM " . $classModel::TABLE_NAME . " A " .
            implode(" ", $tableJoinList) . $condition;

        $product =  DB::selectOne($sql, ["id" => $id]);
        return response()->json($product);
    }

    public function create($model)
    {
        $input = request()->all();
        $input["model"] = $model;
        return CallService::run("Get", $input);
    }

    public function update($model)
    {
        $classModel = "\\App\\Models\\" . Str::upper(Str::camel($model));
        if (!class_exists($classModel))
            return $this->notFound();
        if (!$classModel::EDIT)
            return $this->notFound();
        if (!hasPermission("edit-" . $model)) {
            return $this->forbidden();
        }

        $validation = [];

        foreach ($classModel::FIELDS as $item => $value) {
            $validation[$item] = $value["validation_edit"] ?? "";
        }

        $validator = Validator::make(request()->all(), $validation);

        if ($validator->fails()) {
            return ["message" => $validator->errors()->first()];
        }
        $id = request()->input("id");

        $input = $classModel::beforeUpdate(request()->all());

        $inputOnly = [];
        foreach ($classModel::FIELDS as $item => $value) {
            if ($value["edit"])
                $inputOnly[$item] =  $input[$item];
        }

        $classModel::where("id", $id)
            ->update($inputOnly);
        $product = $classModel::find($id);
        $classModel::afterUpdate($product);
        return response()->json($product);
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
        $classModel = "\\App\\Models\\" . Str::upper(Str::camel($model));
        if (!class_exists($classModel))
            return $this->notFound();

        if (!hasPermission("delete-" . $model)) {
            return $this->forbidden();
        }

        $input = request()->all();
        $id = request()->input("id");
        $product =  $classModel::where("id", $id)
            ->delete();
        return [
            "message" => __("message.successfullyDeleted")
        ];
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

    private function toAlpha($data)
    {
        $alphabet =   array(
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
        );
        return $alphabet[$data];
    }
}
