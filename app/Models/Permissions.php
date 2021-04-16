<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Permissions extends Model
{
    protected $table = 'permissions';
    const TABLE = "permissions";
    const IS_LIST = true;
    const IS_ADD = true;
    const IS_EDIT = true;
    const IS_DELETE = true;
    const IS_VIEW = true;
    const FIELD_LIST = ["id", "name", "modules_id", "description", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_ADD = ["name", "modules_id", "description", "active", "created_by", "updated_by"];
    const FIELD_EDIT = ["name", "modules_id", "description", "active", "updated_by"];
    const FIELD_VIEW = ["id", "name", "modules_id", "description", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_READONLY = [];
    const FIELD_FILTERABLE = ["id", "name", "modules_id", "modules_id", "description", "active", "created_by", "created_by", "updated_by", "updated_by", "created_at", "updated_at"];
    const FIELD_SEARCHABLE = ["name", "description"];
    const FIELD_SORTABLE = ["id", "name", "modules_id", "description", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_TYPE = [
        "id" => "bigint",
        "name" => "character varying",
        "modules_id" => "bigint",
        "description" => "text",
        "active" => "integer",
        "created_by" => "bigint",
        "updated_by" => "bigint",
        "created_at" => "timestamp with time zone",
        "updated_at" => "timestamp with time zone",
    ];
    const FIELD_RELATION = [
    ];
    const FIELD_VALIDATION = [
        "id" => "",
        "name" => "",
        "modules_id" => "",
        "description" => "",
        "active" => "",
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
