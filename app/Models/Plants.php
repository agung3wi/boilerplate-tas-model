<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Plants extends Model
{
    protected $table = 'plants';
    const TABLE = "plants";
    const IS_LIST = true;
    const IS_ADD = true;
    const IS_EDIT = true;
    const IS_DELETE = true;
    const IS_VIEW = true;
    const FIELD_LIST = ["id", "plant_sso_id", "name", "telepon", "address", "description", "singlef_photo", "latitude", "longitude", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_ADD = ["plant_sso_id", "name", "telepon", "address", "description", "singlef_photo", "latitude", "longitude", "active", "created_by", "updated_by"];
    const FIELD_EDIT = ["plant_sso_id", "name", "telepon", "address", "description", "singlef_photo", "latitude", "longitude", "active", "updated_by"];
    const FIELD_VIEW = ["id", "plant_sso_id", "name", "telepon", "address", "description", "singlef_photo", "latitude", "longitude", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_READONLY = [];
    const FIELD_FILTERABLE = ["id", "plant_sso_id", "name", "telepon", "address", "description", "singlef_photo", "latitude", "longitude", "active", "created_by", "created_by", "updated_by", "updated_by", "created_at", "updated_at"];
    const FIELD_SEARCHABLE = ["plant_sso_id", "name", "telepon", "address", "description", "singlef_photo", "latitude", "longitude"];
    const FIELD_SORTABLE = ["id", "plant_sso_id", "name", "telepon", "address", "description", "singlef_photo", "latitude", "longitude", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_UNIQUE = [["name"], ["plant_sso_id"]];
    const FIELD_UPLOAD = [];
    const FIELD_TYPE = [
        "id" => "bigint",
        "plant_sso_id" => "character varying",
        "name" => "character varying",
        "telepon" => "character varying",
        "address" => "text",
        "description" => "text",
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
        "plant_sso_id" => "",
        "name" => "",
        "telepon" => "",
        "address" => "",
        "description" => "",
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
    ];
    const FIELD_VALIDATION = [
        "plant_sso_id" => "required|string|max:255",
        "name" => "required|string|max:255",
        "telepon" => "nullable|string|max:30",
        "address" => "nullable|string",
        "description" => "nullable|string",
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
