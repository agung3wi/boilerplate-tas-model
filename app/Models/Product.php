<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    protected $table = 'm_product';
    protected $fillable = ["code", "name", "uom_name", "default_price", "created_by", "updated_by"];
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
        "code" => [
            "validation_add" => "",
            "validation_edit" => "",
            "searchable" => true,
            "sortable" => true,
            "filter" => false,
            "filter_operation" => "",
            "default" => "",
            "add" => true,
            "edit" => false,
            "get" => true,
            "find" => true
        ],
        "name" => [
            "validation_add" => "",
            "validation_edit" => "",
            "searchable" => true,
            "sortable" => true,
            "filter" => false,
            "filter_operation" => "",
            "default" => "",
            "add" => true,
            "edit" => true,
            "get" => true,
            "find" => true
        ],
        "default_price" => [
            "validation_add" => "required",
            "validation_edit" => "",
            "searchable" => false,
            "sortable" => true,
            "filter" => false,
            "filter_operation" => "",
            "default" => "",
            "add" => true,
            "edit" => true,
            "get" => true,
            "find" => true
        ],
        "uom_name" => [
            "validation_add" => "",
            "validation_edit" => "",
            "searchable" => true,
            "sortable" => true,
            "filter" => false,
            "filter_operation" => "",
            "default" => "",
            "add" => true,
            "edit" => true,
            "get" => true,
            "find" => true
        ],
        "created_by" => [
            "validation_add" => "",
            "validation_edit" => "",
            "searchable" => false,
            "sortable" => true,
            "filter" => false,
            "filter_operation" => "",
            "default" => "",
            "add" => false,
            "edit" => true,
            "get" => true,
            "find" => true
        ],
        "updated_by" => [
            "validation_add" => "",
            "validation_edit" => "",
            "searchable" => false,
            "sortable" => true,
            "filter" => false,
            "filter_operation" => "",
            "default" => "",
            "add" => false,
            "edit" => true,
            "get" => true,
            "find" => true
        ],
        "created_at" => [
            "validation_add" => "",
            "validation_edit" => "",
            "searchable" => false,
            "sortable" => true,
            "filter" => false,
            "filter_operation" => "",
            "default" => "",
            "add" => false,
            "edit" => true,
            "get" => true,
            "find" => true
        ],
        "updated_at" => [
            "validation_add" => "",
            "validation_edit" => "",
            "searchable" => false,
            "sortable" => true,
            "filter" => false,
            "filter_operation" => "",
            "default" => "",
            "add" => false,
            "edit" => true,
            "get" => true,
            "find" => true
        ],
    ];

    public static function beforeInsert($input)
    {
        $input["code"] = strtoupper($input["code"]);
        return $input;
    }

    public static function afterInsert($object, $input)
    {
    }

    public static function beforeUpdate($input)
    {
        return $input;
    }

    public static function afterUpdate($object, $input)
    {
    }
}
