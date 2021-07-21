<?php

namespace App\Services\Crud;

use App\CoreService\CoreException;
use App\CoreService\CoreService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Find extends CoreService
{

    public $transaction = false;
    public $task = null;

    public function prepare($input)
    {
        $model = $input["model"];
        $classModel = "\\App\\Models\\" . Str::ucfirst(Str::camel($model));
        if (!class_exists($classModel))
            throw new CoreException(__("message.model404", ['model' => $model]), 404);

        if (!$classModel::IS_LIST)
            throw new CoreException("Not found", 404);

        if (!hasPermission("view-" . $model))
            throw new CoreException(__("message.403"), 403);

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



        $object =  DB::selectOne($sql, $params);
        if (is_null($object)) {
            throw new CoreException(__("message.dataNotFound", ['id' => $input["id"]]));
        }
        // FORMAT IMAGE
        if (!empty($classModel::FIELD_UPLOAD)) {
            foreach ($classModel::FIELD_UPLOAD as $item) {
                if (preg_match("/file_/i", $item) or preg_match("/img_/i", $item)) {
                    $url = URL::to('api/file/' . $classModel::TABLE . '/' . $item . '/' . $object->id);
                    $tumbnailUrl = URL::to('api/tumb-file/' . $classModel::TABLE . '/' . $item . '/' . $object->id);
                    $ext = pathinfo($object->$item, PATHINFO_EXTENSION);
                    $filename = pathinfo(storage_path($object->$item), PATHINFO_BASENAME);
                    $object->$item = (object) [
                        "ext" => (is_null($object->$item)) ? null : $ext,
                        "url" => $url,
                        "tumbnail_url" => $tumbnailUrl,
                        "filename" => (is_null($object->$item)) ? null : $filename,
                        "field_value" => $object->$item
                    ];
                }
                if (preg_match("/array_/i", $item)) {
                    $key->$item = unserialize($key->$item);
                    if(!$key->$item){
                        $key->$item = null;
                    }
                }
            }
        }
        return [
            "data" => $object
        ];
    }

    protected function validation()
    {
        return [];
    }
}
