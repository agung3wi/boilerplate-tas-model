<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CutOffPeriod extends Model
{
    protected $table = 'cut_off_period';
    const TABLE = "cut_off_period";
    const IS_LIST = true;
    const IS_ADD = true;
    const IS_EDIT = true;
    const IS_DELETE = true;
    const IS_VIEW = true;
    const FIELD_LIST = ["id", "year", "months_id", "start_date", "end_date", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_ADD = ["year", "months_id", "start_date", "end_date", "created_by", "updated_by"];
    const FIELD_EDIT = ["year", "months_id", "start_date", "end_date", "updated_by"];
    const FIELD_VIEW = ["id", "year", "months_id", "start_date", "end_date", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_READONLY = [];
    const FIELD_FILTERABLE = ["id", "year", "months_id", "start_date", "end_date", "created_by", "created_by", "updated_by", "updated_by", "created_at", "updated_at"];
    const FIELD_SEARCHABLE = [];
    const FIELD_SORTABLE = ["id", "year", "months_id", "start_date", "end_date", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_TYPE = [
        "id" => "bigint",
        "year" => "integer",
        "months_id" => "integer",
        "start_date" => "date",
        "end_date" => "date",
        "created_by" => "bigint",
        "updated_by" => "bigint",
        "created_at" => "timestamp with time zone",
        "updated_at" => "timestamp with time zone",
    ];
    const FIELD_RELATION = [
    ];
    const FIELD_VALIDATION = [
        "id" => "required|integer",
        "year" => "required|integer",
        "months_id" => "required|integer",
        "start_date" => "required",
        "end_date" => "required",
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
