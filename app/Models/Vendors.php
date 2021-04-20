<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Vendors extends Model
{
    protected $table = 'vendors';
    const TABLE = "vendors";
    const FILEROOT = "/vendors";
    const IS_LIST = true;
    const IS_ADD = true;
    const IS_EDIT = true;
    const IS_DELETE = true;
    const IS_VIEW = true;
    const FIELD_LIST = ["id", "vendor_sso_id", "name", "telepon", "address", "description", "singlef_photo", "latitude", "longitude", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_ADD = ["vendor_sso_id", "name", "telepon", "address", "description", "singlef_photo", "latitude", "longitude", "active", "created_by", "updated_by"];
    const FIELD_EDIT = ["vendor_sso_id", "name", "telepon", "address", "description", "singlef_photo", "latitude", "longitude", "active", "updated_by"];
    const FIELD_VIEW = ["id", "vendor_sso_id", "name", "telepon", "address", "description", "singlef_photo", "latitude", "longitude", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_READONLY = [];
    const FIELD_FILTERABLE = ["id", "vendor_sso_id", "name", "telepon", "address", "description", "singlef_photo", "latitude", "longitude", "active", "created_by", "created_by", "updated_by", "updated_by", "created_at", "updated_at"];
    const FIELD_SEARCHABLE = ["address", "description", "singlef_photo", "latitude", "longitude"];
    const FIELD_SORTABLE = ["id", "vendor_sso_id", "name", "telepon", "address", "description", "singlef_photo", "latitude", "longitude", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_UNIQUE = [["name"], ["vendor_sso_id"]];
    const FIELD_UPLOAD = ["singlef_photo"];
    const FIELD_TYPE = [
        "id" => "bigint",
        "vendor_sso_id" => "varchar",
        "name" => "varchar",
        "telepon" => "varchar",
        "address" => "text",
        "description" => "text",
        "singlef_photo" => "text",
        "latitude" => "text",
        "longitude" => "text",
        "active" => "int",
        "created_by" => "bigint",
        "updated_by" => "bigint",
        "created_at" => "timestamp",
        "updated_at" => "timestamp",
    ];

    const FIELD_DEFAULT_VALUE = [
        "vendor_sso_id" => "",
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
        "vendor_sso_id" => "required|max:255",
        "name" => "required|max:255",
        "telepon" => "nullable|max:30",
        "address" => "nullable|string|max:65535",
        "description" => "nullable|string|max:65535",
        "singlef_photo" => "nullable|string|max:65535|exists_file",
        "latitude" => "nullable|string|max:65535",
        "longitude" => "nullable|string|max:65535",
        "active" => "nullable",
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
