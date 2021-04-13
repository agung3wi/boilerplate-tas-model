<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Department extends Model
{
    protected $table = 'm_department';
    protected $fillable = [];
    const TABLE_NAME = "m_department";
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
        "department_name" => [
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
                "table_name" => "",
                "column_name" => ""
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
        $input["department_name"] = strtoupper("AVC");
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
