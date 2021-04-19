<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ProblemClassification extends Model
{
    protected $table = 'problem_classification';
    const TABLE = "problem_classification";
    const IS_LIST = true;
    const IS_ADD = true;
    const IS_EDIT = true;
    const IS_DELETE = true;
    const IS_VIEW = true;
    const FIELD_LIST = ["id", "problem_catogorys_id", "problem_identification", "description", "disposition_id", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_ADD = ["problem_catogorys_id", "problem_identification", "description", "disposition_id", "active", "created_by", "updated_by"];
    const FIELD_EDIT = ["problem_catogorys_id", "problem_identification", "description", "disposition_id", "active", "updated_by"];
    const FIELD_VIEW = ["id", "problem_catogorys_id", "problem_identification", "description", "disposition_id", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_READONLY = [];
    const FIELD_FILTERABLE = ["id", "problem_catogorys_id", "problem_catogorys_id", "problem_identification", "description", "disposition_id", "active", "created_by", "created_by", "updated_by", "updated_by", "created_at", "updated_at"];
    const FIELD_SEARCHABLE = ["problem_identification", "description", "disposition_id"];
    const FIELD_SORTABLE = ["id", "problem_catogorys_id", "problem_identification", "description", "disposition_id", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_UNIQUE = [["problem_catogorys_id", "problem_identification"]];
    const FIELD_TYPE = [
        "id" => "bigint",
        "problem_catogorys_id" => "bigint",
        "problem_identification" => "character varying",
        "description" => "text",
        "disposition_id" => "text",
        "active" => "integer",
        "created_by" => "bigint",
        "updated_by" => "bigint",
        "created_at" => "timestamp with time zone",
        "updated_at" => "timestamp with time zone",
    ];
    const FIELD_RELATION = [
    ];
    const FIELD_VALIDATION = [
        "id" => "required|integer",
        "problem_catogorys_id" => "nullable|integer",
        "problem_identification" => "required|string|max:255",
        "description" => "nullable|string",
        "disposition_id" => "nullable|string",
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
