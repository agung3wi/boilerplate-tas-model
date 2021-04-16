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

    private function toAlpha($data)
    {
        $alphabet =   array(
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
        );
        return $alphabet[$data];
    }
}
