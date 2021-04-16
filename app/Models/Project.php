<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Project extends Model
{
    protected $table = 'm_project';
    const TABLE = "m_project";
    const IS_LIST = true;
    const IS_ADD = true;
    const IS_EDIT = true;
    const IS_DELETE = true;
    const IS_VIEW = true;
    const FIELD_LIST = ["id", "project_name", "department_id", "description", "project_img", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_ADD = ["project_name", "department_id", "description", "project_img", "created_by", "updated_by"];
    const FIELD_EDIT = ["project_name", "department_id", "description", "project_img", "updated_by"];
    const FIELD_VIEW = ["id", "project_name", "department_id", "description", "project_img", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_READONLY = [];
    const FIELD_FILTERABLE = ["id", "project_name", "department_id", "department_id", "description", "project_img", "created_by", "created_by", "updated_by", "updated_by", "created_at", "updated_at"];
    const FIELD_SEARCHABLE = ["project_name", "description", "project_img"];
    const FIELD_SORTABLE = ["id", "project_name", "department_id", "description", "project_img", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_TYPE = [
        "id" => "bigint",
        "project_name" => "character varying",
        "department_id" => "bigint",
        "description" => "text",
        "project_img" => "character varying",
        "created_by" => "bigint",
        "updated_by" => "bigint",
        "created_at" => "timestamp without time zone",
        "updated_at" => "timestamp without time zone",
    ];
    const FIELD_RELATION = [
        "department_id" => [
            "linkTable" => "m_department",
            "linkField" => "id",
            "selectValue" => "*"
        ],
        "created_by" => [
            "linkTable" => "users",
            "linkField" => "id",
            "selectValue" => "username AS created_username"
        ],
        "updated_by" => [
            "linkTable" => "users",
            "linkField" => "id",
            "selectValue" => "username AS updated_username"
        ],
    ];
    const FIELD_VALIDATION = [
        "id" => "required|integer",
        "project_name" => "required|string|max:100",
        "department_id" => "required|integer",
        "description" => "required|string",
        "project_img" => "required|string|max:255",
        "created_by" => "required|integer",
        "updated_by" => "required|integer",
        "created_at" => "nullable",
        "updated_at" => "nullable",
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
