<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    protected $table = 'm_product';
    const TABLE = "m_product";
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
    const FIELD_SEARCHABLE = ["code", "name", "uom_name"];
    const FIELD_SORTABLE = ["id", "code", "name", "default_price", "uom_name", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_TYPE = [
        "id" => "bigint",
        "code" => "character varying",
        "name" => "character varying",
        "default_price" => "numeric",
        "uom_name" => "character varying",
        "created_by" => "bigint",
        "updated_by" => "bigint",
        "created_at" => "timestamp without time zone",
        "updated_at" => "timestamp without time zone",
    ];
    const FIELD_RELATION = [
    ];
    const FIELD_VALIDATION = [
        "id" => "",
        "code" => "",
        "name" => "",
        "default_price" => "",
        "uom_name" => "",
        "created_by" => "",
        "updated_by" => "",
        "created_at" => "",
        "updated_at" => "",
    ];
    const PARENT_CHILD = [];

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
}
