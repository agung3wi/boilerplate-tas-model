<?php

namespace App\Services\Crud;

use App\CoreService\CoreException;
use App\CoreService\CoreService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Dataset extends CoreService
{

    public $transaction = false;
    public $task = null;

    public function prepare($input)
    {
        $model = $input["model"];
        $classModel = "\\App\\Models\\" . Str::ucfirst(Str::camel($model));
        if (!class_exists($classModel))
            throw new CoreException(__("message.model404", [ 'model' =>$model]), 404);

        if (!$classModel::IS_LIST)
            throw new CoreException(__("message.404"), 404);

        if (!hasPermission("view-" . $model))
            throw new CoreException(__("message.403"), 403);

        $input["class_model"] = $classModel;
        return $input;
    }

    public function process($input, $originalInput)
    {
        $classModel = $input["class_model"];

        $selectableList = [];
        $sortBy = $classModel::TABLE . ".id";
        $sort = strtoupper($input["sort"] ?? "DESC") == "ASC" ? "ASC" : "DESC";

        $sortableList = $classModel::FIELD_SORTABLE;

        if (in_array($input["sort_by"] ?? "", $sortableList)) {
            $sortBy = $input["sort_by"];
        }

        $tableJoinList = [];
        $filterList = [];
        $params = [];

        foreach ($classModel::FIELD_LIST as $list) {
            $selectableList[] = $classModel::TABLE . "." . $list;
        }

        foreach ($classModel::FIELD_FILTERABLE as $filter) {
            if (!is_blank($input, $filter)) {
                $filterList[] = " AND " . $classModel::TABLE . "." . $filter .  " = :$filter";
                $params[$filter] = $input[$filter];
            }
        }
        $i = 0;
        foreach ($classModel::FIELD_RELATION as $key => $relation) {
            // $alias = toAlpha($i + 1);
            $alias = $relation["aliasTable"];
            $selectableList[] = $alias . "." . $relation["selectValue"];

            $tableJoinList[] = "LEFT JOIN " . $relation["linkTable"] . " " . $alias . " ON " .
                $classModel::TABLE . "." . $key . " = " .  $alias . "." . $relation["linkField"];
            $i++;
        }

        if (!empty($classModel::CUSTOM_SELECT)) $selectableList[] = $classModel::CUSTOM_SELECT;

        $condition = " WHERE true";

        if (!is_blank($input, "search")) {

            $searchableList = $classModel::FIELD_SEARCHABLE;

            $searchableList = array_map(function ($item) {
                return "UPPER($item) ILIKE :search";
            }, $searchableList);
        } else {
            $searchableList = [];
        }



        if (count($searchableList) > 0 && !is_blank($input, "search"))
            $params["search"] = "%" . strtoupper($input["search"] ?? "") . "%";

        $limit = $input["limit"] ?? 10;
        $offset = $input["offset"] ?? 0;
        if (!is_null($input["page"] ?? null)) {
            $offset = $limit * ($input["page"] - 1);
        }


        $sql = "SELECT " . implode(", ", $selectableList) . " FROM " . $classModel::TABLE . " " .
            implode(" ", $tableJoinList) . $condition .
            (count($searchableList) > 0 ? " AND (" . implode(" OR ", $searchableList) . ")" : "") .
            implode("\n", $filterList) . " ORDER BY " . $sortBy . " " . $sort . " LIMIT $limit OFFSET $offset ";

        $sqlForCount = "SELECT COUNT(1) AS total FROM " . $classModel::TABLE . " " .
            implode(" ", $tableJoinList) . $condition .
            (count($searchableList) > 0 ? " AND (" . implode(" OR ", $searchableList) . ")" : "") .
            implode("\n", $filterList);

        $productList =  DB::select($sql, $params);
        array_map(function ($key) use ($classModel) {
            foreach ($key as $field => $value) {
                if (preg_match("/file_/i", $field) or preg_match("/img_/i", $field)) {
                    $url = URL::to('api/file/' . $classModel::TABLE . '/' . $field . '/' . $key->id . '/' . $key->$field);
                    $ext = pathinfo($url, PATHINFO_EXTENSION);
                    $key->$field = (object) [
                        "ext" => $ext,
                        "url" => $url,
                        "filename" => $key->$field
                    ];
                }
            }
            return $key;
        }, $productList);
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
