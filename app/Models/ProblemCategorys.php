<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ProblemCategorys extends Model
{
    protected $table = 'problem_categorys';
    const TABLE = "problem_categorys";
    const IS_LIST = true;
    const IS_ADD = true;
    const IS_EDIT = true;
    const IS_DELETE = true;
    const IS_VIEW = true;
    const FIELD_LIST = ["id", "name", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_ADD = ["name", "active", "created_by", "updated_by"];
    const FIELD_EDIT = ["name", "active", "updated_by"];
    const FIELD_VIEW = ["id", "name", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_READONLY = [];
    const FIELD_FILTERABLE = ["id", "name", "active", "created_by", "created_by", "updated_by", "updated_by", "created_at", "updated_at"];
    const FIELD_SEARCHABLE = ["name"];
    const FIELD_SORTABLE = ["id", "name", "active", "created_by", "updated_by", "created_at", "updated_at"];
    const FIELD_UNIQUE = [["name"]];
    const FIELD_TYPE = [
        "id" => "bigint",
        "name" => "character varying",
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
        "name" => "required|string|max:255",
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
