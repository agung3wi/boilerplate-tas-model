<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Uom extends Model
{
    protected $table = 'm_uom';
    protected $fillable = [];
    const TABLE_NAME = "m_uom";
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
        "uom_code" => [
            "validation_add" => "required",
            "validation_edit" => "required",
            "searchable" => true,
            "sortable" => true,
            "filter" => false,
            "filter_operation" => "",
            "default" => "",
            "add" => true,
            "edit" => true,
            "get" => true,
            "find" => true
        ],
        "uom_name" => [
            "validation_add" => "required",
            "validation_edit" => "required",
            "searchable" => true,
            "sortable" => true,
            "filter" => false,
            "filter_operation" => "",
            "default" => "",
            "add" => true,
            "edit" => true,
            "get" => true,
            "find" => true
        ],
        "created_at" => [
            "validation_add" => "required",
            "validation_edit" => "required",
            "searchable" => true,
            "sortable" => true,
            "filter" => false,
            "filter_operation" => "",
            "default" => "",
            "add" => true,
            "edit" => true,
            "get" => true,
            "find" => true
        ],
        "updated_at" => [
            "validation_add" => "required",
            "validation_edit" => "required",
            "searchable" => true,
            "sortable" => true,
            "filter" => false,
            "filter_operation" => "",
            "default" => "",
            "add" => true,
            "edit" => true,
            "get" => true,
            "find" => true
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
