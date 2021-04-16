<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class RolePermissions extends Model
{
    protected $table = 'role_permissions';
    const TABLE = "role_permissions";
    const IS_LIST = true;
    const IS_ADD = true;
    const IS_EDIT = true;
    const IS_DELETE = true;
    const IS_VIEW = true;
    const FIELD_LIST = ["id", "permissions_id", "userlevels_id", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_ADD = ["permissions_id", "userlevels_id", "active", "created_by", "updated_by"];
    const FIELD_EDIT = ["permissions_id", "userlevels_id", "active", "updated_by"];
    const FIELD_VIEW = ["id", "permissions_id", "userlevels_id", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_READONLY = [];
    const FIELD_FILTERABLE = ["id", "permissions_id", "permissions_id", "userlevels_id", "userlevels_id", "active", "created_by", "created_by", "updated_by", "updated_by", "created_at", "updated_at"];
    const FIELD_SEARCHABLE = [];
    const FIELD_SORTABLE = ["id", "permissions_id", "userlevels_id", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_TYPE = [
        "id" => "bigint",
        "permissions_id" => "bigint",
        "userlevels_id" => "bigint",
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
        "permissions_id" => "",
        "userlevels_id" => "",
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
