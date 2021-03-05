<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    protected $table = 'm_product';
    protected $fillable = ['product_code', 'product_name', 'description', 'uom_id'];
    const TABLE_NAME = "m_product";
    const ADD = true;
    const EDIT = true;
    const DELETE = true;
    const GET = true;
    const FIND = true;
    const REMOVE = true;
    const RESTORE = true;
    const PRIMARY_KEY = "id";
    const TIMESTAMP = true;

    const FIELDS = [
        "product_name" => [
            "validation_add" => "required|min:10|max",
            "validation_edit" => "required",
            "searchable" => true,
            "sortable" => true,
            "filter" => false,
            "default" => "",
            "add" => true,
            "edit" => true,
            "get" => true,
            "find" => true
        ],
        "product_code" => [
            "validation_add" => "required|unique:m_product",
            "validation_edit" => "",
            "searchable" => true,
            "sortable" => true,
            "filter" => false,
            "default" => "",
            "add" => true,
            "edit" => false,
            "get" => true,
            "find" => true
        ],
        "description" => [
            "searchable" => true,
            "sortable" => true,
            "filter" => false,
            "default" => "",
            "add" => true,
            "edit" => true,
            "get" => false,
            "find" => true
        ],
        "uom_id" => [
            "searchable" => false,
            "sortable" => true,
            "filter" => true,
            "filter_op" => "=",
            "default" => "",
            "add" => true,
            "edit" => true,
            "get" => true,
            "find" => true,
            "relation" => [
                "table" => "m_uom",
                "field_reference" => "id",
                "selectable" => ["uom_name"]
            ]
        ]
    ];

    public static function beforeInsert($input)
    {
        return $input;
    }

    public static function afterInsert($object)
    {
        Log::debug(json_encode($object));
    }

    public static function beforeUpdate($input)
    {
        $input["product_name"] = strtoupper($input["product_name"]);
        return $input;
    }

    public static function afterUpdate($object)
    {
        Log::debug(json_encode($object));
    }
}
