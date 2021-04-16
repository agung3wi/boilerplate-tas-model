<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ProductionPlans extends Model
{
    protected $table = 'production_plans';
    const TABLE = "production_plans";
    const IS_LIST = true;
    const IS_ADD = true;
    const IS_EDIT = true;
    const IS_DELETE = true;
    const IS_VIEW = true;
    const FIELD_LIST = ["id", "plants_id", "year", "months_id", "consumers_id", "materials_id", "volume", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_ADD = ["plants_id", "year", "months_id", "consumers_id", "materials_id", "volume", "created_by", "updated_by"];
    const FIELD_EDIT = ["plants_id", "year", "months_id", "consumers_id", "materials_id", "volume", "updated_by"];
    const FIELD_VIEW = ["id", "plants_id", "year", "months_id", "consumers_id", "materials_id", "volume", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_READONLY = [];
    const FIELD_FILTERABLE = ["id", "plants_id", "plants_id", "year", "year", "months_id", "months_id", "consumers_id", "consumers_id", "materials_id", "materials_id", "volume", "created_by", "created_by", "updated_by", "updated_by", "created_at", "updated_at"];
    const FIELD_SEARCHABLE = [];
    const FIELD_SORTABLE = ["id", "plants_id", "year", "months_id", "consumers_id", "materials_id", "volume", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_TYPE = [
        "id" => "bigint",
        "plants_id" => "bigint",
        "year" => "bigint",
        "months_id" => "bigint",
        "consumers_id" => "bigint",
        "materials_id" => "bigint",
        "volume" => "double precision",
        "created_by" => "bigint",
        "updated_by" => "bigint",
        "created_at" => "timestamp with time zone",
        "updated_at" => "timestamp with time zone",
    ];
    const FIELD_RELATION = [
    ];
    const FIELD_VALIDATION = [
        "id" => "required|integer",
        "plants_id" => "nullable|integer",
        "year" => "nullable|integer",
        "months_id" => "nullable|integer",
        "consumers_id" => "nullable|integer",
        "materials_id" => "nullable|integer",
        "volume" => "required",
        "created_by" => "nullable|integer",
        "updated_by" => "nullable|integer",
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
