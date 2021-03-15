
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class {{ $studly_caps }} extends Model
{
    protected $table = '{{ $table_name }}';
    protected $fillable = [];
    const TABLE_NAME = "{{ $table_name }}";
    const ADD = {{ $add? "true" : "false" }};
    const EDIT = true;
    const DELETE = true;
    const GET = true;
    const FIND = true;
    const REMOVE = true;
    const RESTORE = true;
    const PRIMARY_KEY = "id";
    const TIMESTAMP = true;

    const FIELDS = [
@foreach ($fields as $field => $value)
@if($field != "id")
        "{{$field}}" => [
            "validation_add" => "{{ $value["validation_add"] }}",
            "validation_edit" => "{{ $value["validation_edit"] }}",
            "searchable" => {{ $value["searchable"]? "true" : "false" }},
            "sortable" => {{ $value["sortable"]? "true" : "false" }},
            "filter" => {{ $value["filter"]? "true" : "false" }},
            "filter_operation" => "{{ $value["filter_operation"] ?? "" }}",
            "default" => "",
            "add" => {{ $value["add"]? "true" : "false" }},
            "edit" => {{ $value["edit"]? "true" : "false" }},
            "get" => {{ $value["get"]? "true" : "false" }},
            "find" => {{ $value["find"]? "true" : "false" }}
        ],
@endif
@endforeach
    ];

    public static function beforeInsert($input)
    {{{$before_insert}}}

    public static function afterInsert($object, $input)
    {{{$after_insert}}}

    public static function beforeUpdate($input)
    {{{$before_update}}}

    public static function afterUpdate($object, $input)
    {{{$after_update}}}
}
