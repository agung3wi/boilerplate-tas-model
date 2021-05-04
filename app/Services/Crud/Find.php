<?php

namespace App\Services\Crud;

use App\CoreService\CoreException;
use App\CoreService\CoreService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Find extends CoreService
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
        $tableJoinList = [];
        $params = ["id" => $input["id"]];

        foreach ($classModel::FIELD_VIEW as $list) {
            $selectableList[] = "A." . $list;
        }

        $i = 0;
        foreach ($classModel::FIELD_RELATION as $key => $relation) {
            $alias = toAlpha($i + 1);
            $selectableList[] = $alias . "." . $relation["selectValue"];

            $tableJoinList[] = "LEFT JOIN " . $relation["linkTable"] . " " . $alias . " ON " .
                "A." . $key . " = " .  $alias . "." . $relation["linkField"];
            $i++;
        }
        $condition = " WHERE A.id = :id";

        $sql = "SELECT " . implode(", ", $selectableList) . " FROM " . $classModel::TABLE . " A " .
            implode(" ", $tableJoinList) . $condition;

        
        
        $detail =  DB::selectOne($sql, $params);
        if(is_null($detail)) {
            throw new CoreException(__("message.dataNotFound", [ 'id' =>$input["id"]] ));
        }

        return $detail;
      
    }

    protected function validation()
    {
        return [];
    }
}
