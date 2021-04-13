<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Project extends Model
{
    protected $table = 'm_project';
    protected $fillable = [];
    const TABLE_NAME = "m_project";
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
        "created_by" => [
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
            "find" => true,
            "relation" => [
                "table_name" => "users",
                "column_name" => "id"
            ]
        ],
        "department_id" => [
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
            "find" => true,
            "relation" => [
                "table_name" => "m_department",
                "column_name" => "id"
            ]
        ],
        "updated_by" => [
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
            "find" => true,
            "relation" => [
                "table_name" => "users",
                "column_name" => "id"
            ]
        ],
        "project_name" => [
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
            "find" => true,
            "relation" => [
                "table_name" => "",
                "column_name" => ""
            ]
        ],
        "description" => [
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
            "find" => true,
            "relation" => [
                "table_name" => "",
                "column_name" => ""
            ]
        ],
        "project_img" => [
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
            "find" => true,
            "relation" => [
                "table_name" => "",
                "column_name" => ""
            ]
        ],
        "created_at" => [
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
            "find" => true,
            "relation" => [
                "table_name" => "",
                "column_name" => ""
            ]
        ],
        "updated_at" => [
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
            "find" => true,
            "relation" => [
                "table_name" => "",
                "column_name" => ""
            ]
        ],
    ];

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
