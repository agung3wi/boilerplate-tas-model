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

        if (!$classModel::IS_LIST)
            throw New CoreException("Not found", 404);

        if (!hasPermission("view-" . $model))
            throw New CoreException(Auth(), 403);

        $input["class_model"] = $classModel;
        return $input;
    }

    public function process($input, $originalInput)
    {
        $classModel = $input["class_model"];        

        $selectableList = [];
        $sortBy = "A.id";
        $sort = strtoupper($input["sort"] ?? "DESC") == "ASC" ? "ASC" : "DESC";

        $sortableList = $classModel::FIELD_SORTABLE;

        if (in_array($input["sort_by"] ?? "", $sortableList)) {
            $sortBy = $input["sort_by"];
        }

        $tableJoinList = [];
        $filterList = [];
        $params = [];

        foreach ($classModel::FIELD_LIST as $list) {
            $selectableList[] = "A." . $list;
        }

        foreach ($classModel::FIELD_FILTERABLE as $filter) {      
            if(!is_blank($input, $filter)) {     
                $filterList[] = " AND " . $filter .  " = :$filter";
                $params[$filter] = $input[$filter];
            }
        }
        $i = 0;
        foreach ($classModel::FIELD_RELATION as $relation) {
            $alias = toAlpha($i + 1);
            $selectableList[] = $alias . "." . $relation["selectValue"];

            $tableJoinList[] = "LEFT JOIN " . $relation["linkTable"] . " " . $alias . " ON " .
                "A." . $relation["linkField"] . " = " .  $alias . ".id";
            $i++;
        }
        $condition = " WHERE true";

        if(!is_blank($input, "src")) {
            $searchableList = $classModel::FIELD_SEARCHABLE;

            $searchableList = array_map(function ($item) {
                return "UPPER($item) LIKE :src";
            }, array_keys($searchableList), $searchableList);
        } else {
            $searchableList = [];
        }

        if(count($searchableList)>0)
            $params["src"] = "%" . strtoupper($input["src"] ?? "") . "%";

        $limit = $input["limit"] ?? 10;
        $offset = $input["offset"] ?? 0;
        if (!is_null($input["page"] ?? null)) {
            $offset = $limit * ($input["page"] - 1);
        }
        

        $sql = "SELECT " . implode(", ", $selectableList) . " FROM " . $classModel::TABLE . " A " .
            implode(" ", $tableJoinList) . $condition .
            (count($searchableList) > 0 ? " AND (" . implode(" OR ", $searchableList) . ")" : "").
            implode("\n", $filterList) . " ORDER BY " . $sortBy . " " . $sort . " LIMIT $limit OFFSET $offset ";

        $sqlForCount = "SELECT COUNT(1) AS total FROM " . $classModel::TABLE . " A " .
            implode(" ", $tableJoinList) . $condition .
            (count($searchableList) > 0 ? " AND (" . implode(" OR ", $searchableList) . ")" : "").
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
