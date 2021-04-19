<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Projects extends Model
{
    protected $table = 'projects';
    const TABLE = "projects";
    const IS_LIST = true;
    const IS_ADD = true;
    const IS_EDIT = true;
    const IS_DELETE = true;
    const IS_VIEW = true;
    const FIELD_LIST = ["id", "departments_id", "name", "address", "singlef_photo", "latitude", "longitude", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_ADD = ["departments_id", "name", "address", "singlef_photo", "latitude", "longitude", "active", "created_by", "updated_by"];
    const FIELD_EDIT = ["departments_id", "name", "address", "singlef_photo", "latitude", "longitude", "active", "updated_by"];
    const FIELD_VIEW = ["id", "departments_id", "name", "address", "singlef_photo", "latitude", "longitude", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_READONLY = [];
    const FIELD_FILTERABLE = ["id", "departments_id", "departments_id", "name", "address", "singlef_photo", "latitude", "longitude", "active", "created_by", "created_by", "updated_by", "updated_by", "created_at", "updated_at"];
    const FIELD_SEARCHABLE = ["name", "address", "singlef_photo", "latitude", "longitude"];
    const FIELD_SORTABLE = ["id", "departments_id", "name", "address", "singlef_photo", "latitude", "longitude", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_UNIQUE = [["name"]];
    const FIELD_TYPE = [
        "id" => "bigint",
        "departments_id" => "bigint",
        "name" => "character varying",
        "address" => "text",
        "singlef_photo" => "text",
        "latitude" => "text",
        "longitude" => "text",
        "active" => "integer",
        "created_by" => "bigint",
        "updated_by" => "bigint",
        "created_at" => "timestamp with time zone",
        "updated_at" => "timestamp with time zone",
    ];

    const FIELD_DEFAULT_VALUE = [
        "departments_id" => "",
        "name" => "",
        "address" => "",
        "singlef_photo" => "",
        "latitude" => "",
        "longitude" => "",
        "active" => "1",
        "created_by" => "",
        "updated_by" => "",
        "created_at" => "",
        "updated_at" => "",
    ];
    const FIELD_RELATION = [
        "departments_id" => [
            "linkTable" => "departments",
            "linkField" => "id",
            "selectValue" => "*"
        ],
    ];
    const FIELD_VALIDATION = [
        "departments_id" => "required|integer",
        "name" => "required|string|max:255",
        "address" => "nullable|string",
        "singlef_photo" => "nullable|string",
        "latitude" => "nullable|string",
        "longitude" => "nullable|string",
        "active" => "nullable|integer",
        "created_by" => "nullable|integer",
        "updated_by" => "nullable|integer",
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
