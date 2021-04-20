<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    protected $table = 'm_product';
    const TABLE = "m_product";
    const FILEROOT = "/product";
    const IS_LIST = true;
    const IS_ADD = true;
    const IS_EDIT = true;
    const IS_DELETE = true;
    const IS_VIEW = true;
    const FIELD_LIST = ["id", "code", "name", "default_price", "uom_name", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_ADD = ["code", "name", "default_price", "uom_name", "created_by", "updated_by"];
    const FIELD_EDIT = ["code", "name", "default_price", "uom_name", "updated_by"];
    const FIELD_VIEW = ["id", "code", "name", "default_price", "uom_name", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_READONLY = [];
    const FIELD_FILTERABLE = ["id", "code", "name", "default_price", "uom_name", "created_by", "created_by", "updated_by", "updated_by", "created_at", "updated_at"];
    const FIELD_SEARCHABLE = [];
    const FIELD_SORTABLE = ["id", "code", "name", "default_price", "uom_name", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_UNIQUE = [["code"]];
    const FIELD_UPLOAD = [];
    const FIELD_TYPE = [
        "id" => "bigint",
        "code" => "varchar",
        "name" => "varchar",
        "default_price" => "decimal",
        "uom_name" => "varchar",
        "created_by" => "bigint",
        "updated_by" => "bigint",
        "created_at" => "timestamp",
        "updated_at" => "timestamp",
    ];

    const FIELD_DEFAULT_VALUE = [
        "code" => "",
        "name" => "",
        "default_price" => "",
        "uom_name" => "",
        "created_by" => "",
        "updated_by" => "",
        "created_at" => "",
        "updated_at" => "",
    ];
    const FIELD_RELATION = [
    ];
    const FIELD_VALIDATION = [
        "code" => "required|max:100",
        "name" => "required|max:100",
        "default_price" => "required",
        "uom_name" => "required|max:100",
        "created_by" => "required|integer",
        "updated_by" => "required|integer",
        "created_at" => "nullable|date",
        "updated_at" => "nullable|date",
    ];
    const PARENT_CHILD = [];

    // start custom
    public static function beforeInsert($input)
    {
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
    // end custom
}
