<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class MasterMaterials extends Model
{
    protected $table = 'master_materials';
    const TABLE = "master_materials";
    const IS_LIST = true;
    const IS_ADD = true;
    const IS_EDIT = true;
    const IS_DELETE = true;
    const IS_VIEW = true;
    const FIELD_LIST = ["id", "category_materials_id", "name", "uom", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_ADD = ["category_materials_id", "name", "uom", "active", "created_by", "updated_by"];
    const FIELD_EDIT = ["category_materials_id", "name", "uom", "active", "updated_by"];
    const FIELD_VIEW = ["id", "category_materials_id", "name", "uom", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_READONLY = [];
    const FIELD_FILTERABLE = ["id", "category_materials_id", "name", "uom", "active", "created_by", "created_by", "updated_by", "updated_by", "created_at", "updated_at"];
    const FIELD_SEARCHABLE = ["category_materials_id", "name", "uom"];
    const FIELD_SORTABLE = ["id", "category_materials_id", "name", "uom", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_UNIQUE = [["name"], ["uom"]];
    const FIELD_TYPE = [
        "id" => "bigint",
        "category_materials_id" => "character varying",
        "name" => "character varying",
        "uom" => "character varying",
        "active" => "integer",
        "created_by" => "bigint",
        "updated_by" => "bigint",
        "created_at" => "timestamp with time zone",
        "updated_at" => "timestamp with time zone",
    ];

    const FIELD_DEFAULT_VALUE = [
        "category_materials_id" => "",
        "name" => "",
        "uom" => "",
        "active" => "1",
        "created_by" => "",
        "updated_by" => "",
        "created_at" => "",
        "updated_at" => "",
    ];
    const FIELD_RELATION = [
    ];
    const FIELD_VALIDATION = [
        "category_materials_id" => "required|string|max:255",
        "name" => "required|string|max:255",
        "uom" => "required|string|max:255",
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
