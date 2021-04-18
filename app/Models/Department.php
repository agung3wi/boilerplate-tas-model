<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Department extends Model
{
    protected $table = 'm_department';
    const TABLE = "m_department";
    const IS_LIST = true;
    const IS_ADD = true;
    const IS_EDIT = true;
    const IS_DELETE = true;
    const IS_VIEW = true;
    const FIELD_LIST = ["id", "department_name", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_ADD = ["department_name", "created_by", "updated_by"];
    const FIELD_EDIT = ["department_name", "updated_by"];
    const FIELD_VIEW = ["id", "department_name", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_READONLY = [];
    const FIELD_FILTERABLE = ["id", "department_name", "created_by", "created_by", "updated_by", "updated_by", "created_at", "updated_at"];
    const FIELD_SEARCHABLE = [];
    const FIELD_SORTABLE = ["id", "department_name", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_UNIQUE = [];
    const FIELD_TYPE = [
        "id" => "bigint",
        "department_name" => "varchar",
        "created_by" => "bigint",
        "updated_by" => "bigint",
        "created_at" => "timestamp",
        "updated_at" => "timestamp",
    ];
    const FIELD_RELATION = [
    ];
    const FIELD_VALIDATION = [
        "id" => "required|integer",
        "department_name" => "required|max:100",
        "created_by" => "required|integer",
        "updated_by" => "required|integer",
        "created_at" => "nullable|date",
        "updated_at" => "nullable|date",
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
