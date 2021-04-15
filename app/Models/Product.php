<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    protected $table = 'm_product';
    protected $fillable = ["code","name","default_price","uom_name","created_by","updated_by"];
    const TABLE_NAME = "m_product";
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
        "code" => [
            "validation_add" => "",
            "validation_edit" => "",
            "searchable" => false,
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
                "column_name" => "",
                "selectable" => []
            ]
        ],
        "name" => [
            "validation_add" => "",
            "validation_edit" => "",
            "searchable" => false,
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
                "column_name" => "",
                "selectable" => []
            ]
        ],
        "default_price" => [
            "validation_add" => "",
            "validation_edit" => "",
            "searchable" => false,
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
                "column_name" => "",
                "selectable" => []
            ]
        ],
        "uom_name" => [
            "validation_add" => "",
            "validation_edit" => "",
            "searchable" => false,
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
                "column_name" => "",
                "selectable" => []
            ]
        ],
        "created_by" => [
            "validation_add" => "",
            "validation_edit" => "",
            "searchable" => false,
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
                "column_name" => "",
                "selectable" => []
            ]
        ],
        "updated_by" => [
            "validation_add" => "",
            "validation_edit" => "",
            "searchable" => false,
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
                "column_name" => "",
                "selectable" => []
            ]
        ],
        "created_at" => [
            "validation_add" => "",
            "validation_edit" => "",
            "searchable" => false,
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
                "column_name" => "",
                "selectable" => []
            ]
        ],
        "updated_at" => [
            "validation_add" => "",
            "validation_edit" => "",
            "searchable" => false,
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
                "column_name" => "",
                "selectable" => []
            ]
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
