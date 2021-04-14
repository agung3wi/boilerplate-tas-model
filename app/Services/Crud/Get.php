<?php

namespace App\Services\Crud;

use App\CoreService\CoreException;
use App\CoreService\CoreService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Get extends CoreService
{

    public $transaction = false;
    public $task = null;

    public function prepare($input)
    {
        $model = $input["model"];
        $classModel = "\\App\\Models\\" . Str::upper(Str::camel($model));
        if (!class_exists($classModel))
            throw New CoreException("Not found", 404);

        if (!$classModel::GET)
            throw New CoreException("Not found", 404);

        // if (!hasPermission("view-" . $model))
        //     throw New CoreException("Forbidden", 403);
        $input["class_model"] = $classModel;
        return $input;
    }

    public function process($input, $originalInput)
    {
        $classModel = $input["class_model"];        

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

        $params["src"] = "%" . strtoupper($input["src"] ?? "") . "%";
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
            if ($value["relation"]["table_name"] != "") {
                $alias = toAlpha($i + 1);
                $selectableList = array_merge($selectableList, array_map(function ($item) use ($alias) {
                    return $alias . "." . $item;
                }, $value["relation"]["selectable"]));

                $tableJoinList[] = "LEFT JOIN " . $value["relation"]["table_name"] . " " . $alias . " ON " .
                    "A." . $item . " = " .  $alias . "." . $value["relation"]["column_name"];
            }
            $i++;
        }

        $condition = " WHERE true";

        $searchableList = array_filter($classModel::FIELDS, function ($item) {
            return $item["searchable"];
        });

        $searchableList = array_map(function ($item) {
            return "UPPER($item) LIKE :src";
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

    protected function validation()
    {
        return [];
    }
}
