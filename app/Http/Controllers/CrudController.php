<?php

namespace App\Http\Controllers;

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
        $classModel = "\\App\\Models\\" . Str::upper(Str::camel($model));
        if (!class_exists($classModel))
            return $this->notFound();
        if (!$classModel::GET)
            return $this->notFound();
        // if (!hasPermission("view-" . $model))
        //     return $this->forbidden();

        $input = request()->all();
        $selectableList = ["A." . ($classModel::PRIMARY_KEY ?? "id")];
        $sortBy = "A." . ($classModel::PRIMARY_KEY ?? "id");
        $sort = strtoupper($input["sort"] ?? "DESC") == "ASC" ? "ASC" : "DESC";

        $sortableList = array_filter($classModel::FIELDS, function ($item) {
            return $item["sortable"];
        });

        $sortableList = array_map(function ($item) {
            return $item;
        }, array_keys($sortableList), $sortableList);

        if (in_array($input["sort_by"] ?? "", $sortableList)) {
            $sortBy = $input["sort_by"];
        }

        $params["src"] = "%" . ($input["src"] ?? "") . "%";
        $tableJoinList = [];
        $filterList = [];

        $i = 0;
        foreach ($classModel::FIELDS as $item => $value) {
            if ($value["get"]) {
                $selectableList[] = "A." . $item;
            }
            if ($value["filter"] && isset($input[$item])) {
                $filterList[] = " AND " . $item . $value["filter_op"] . ":$item";
                $params[$item] = $input[$item];
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

        $condition = " WHERE true";

        $searchableList = array_filter($classModel::FIELDS, function ($item) {
            return $item["searchable"];
        });

        $searchableList = array_map(function ($item) {
            return $item . " ILIKE :src";
        }, array_keys($searchableList), $searchableList);

        $limit = $input["limit"] ?? 10;
        $offset = $input["offset"] ?? 0;
        if (!is_null($input["page"] ?? null)) {
            $offset = $limit * ($input["page"] - 1);
        }

        $sql = "SELECT " . implode(", ", $selectableList) . " FROM " . $classModel::TABLE_NAME . " A " .
            implode(" ", $tableJoinList) . $condition .
            " AND (" . implode(" OR ", $searchableList) . ")" .
            implode("\n", $filterList) . " ORDER BY " . $sortBy . " " . $sort . " LIMIT $limit OFFSET $offset ";

        $sqlForCount = "SELECT COUNT(1) AS total FROM " . $classModel::TABLE_NAME . " A " .
            implode(" ", $tableJoinList) . $condition .
            " AND (" . implode(" OR ", $searchableList) . ")" .
            implode("\n", $filterList);

        $productList =  DB::select($sql, $params);
        $total = DB::selectOne($sqlForCount, $params)->total;
        return [
            "data" => $productList,
            "total" => $total
        ];
    }

    public function show($model, $id)
    {
        $classModel = "\\App\\Models\\" . Str::upper(Str::camel($model));
        if (!class_exists($classModel))
            return $this->notFound();
        if (!$classModel::FIND)
            return $this->notFound();
        // if (!hasPermission("view-" . $model))
        //     return $this->forbidden();

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
        $classModel = "\\App\\Models\\" . Str::upper(Str::camel($model));
        if (!class_exists($classModel))
            return $this->notFound();
        if (!$classModel::ADD)
            return $this->notFound();

        // if (!hasPermission("add-" . $model)) {
        //     return $this->forbidden();
        // }

        $validation = [];

        foreach ($classModel::FIELDS as $item => $value) {
            $validation[$item] = $value["validation_add"] ?? "";
        }

        $validator = Validator::make(request()->all(), $validation);

        if ($validator->fails()) {
            return response()->json(
                ["message" => $validator->errors()->first()],
                422
            );
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

    public function update($model)
    {
        $classModel = "\\App\\Models\\" . Str::upper(Str::camel($model));
        if (!class_exists($classModel))
            return $this->notFound();
        if (!$classModel::EDIT)
            return $this->notFound();
        // if (!hasPermission("edit-" . $model)) {
        //     return $this->forbidden();
        // }

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
