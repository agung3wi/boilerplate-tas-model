<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Project extends Model
{
    protected $table = 'm_project';
    const TABLE = "m_project";
    const FILEROOT = "/project";
    const IS_LIST = true;
    const IS_ADD = true;
    const IS_EDIT = true;
    const IS_DELETE = true;
    const IS_VIEW = true;
    const FIELD_LIST = ["created_by", "department_id", "updated_by", "id", "project_name", "description", "project_img", "created_at", "updated_at"];
    const FIELD_ADD = ["created_by", "department_id", "updated_by", "project_name", "description", "project_img"];
    const FIELD_EDIT = ["department_id", "updated_by", "project_name", "description", "project_img"];
    const FIELD_VIEW = ["created_by", "department_id", "updated_by", "id", "project_name", "description", "project_img", "created_at", "updated_at"];
    const FIELD_READONLY = [];
    const FIELD_FILTERABLE = ["created_by", "created_by", "department_id", "department_id", "updated_by", "updated_by", "id", "project_name", "description", "project_img", "created_at", "updated_at"];
    const FIELD_SEARCHABLE = ["description"];
    const FIELD_SORTABLE = ["created_by", "department_id", "updated_by", "id", "project_name", "description", "project_img", "created_at", "updated_at"];
    const FIELD_UNIQUE = [];
    const FIELD_UPLOAD = [];
    const FIELD_TYPE = [
        "created_by" => "bigint",
        "department_id" => "bigint",
        "updated_by" => "bigint",
        "id" => "bigint",
        "project_name" => "varchar",
        "description" => "text",
        "project_img" => "varchar",
        "created_at" => "timestamp",
        "updated_at" => "timestamp",
    ];

    const FIELD_DEFAULT_VALUE = [
        "created_by" => "",
        "department_id" => "",
        "updated_by" => "",
        "project_name" => "",
        "description" => "",
        "project_img" => "",
        "created_at" => "",
        "updated_at" => "",
    ];
    const FIELD_RELATION = [
        "created_by" => [
            "linkTable" => "users",
            "linkField" => "id",
            "selectValue" => "username AS created_username"
        ],
        "department_id" => [
            "linkTable" => "m_department",
            "linkField" => "id",
            "selectValue" => "*"
        ],
        "updated_by" => [
            "linkTable" => "users",
            "linkField" => "id",
            "selectValue" => "username AS updated_username"
        ],
    ];
    const FIELD_VALIDATION = [
        "created_by" => "required|integer",
        "department_id" => "required|integer",
        "updated_by" => "required|integer",
        "project_name" => "required|max:100",
        "description" => "required|string|max:65535",
        "project_img" => "required|max:255",
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
