
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class {{ $studly_caps }} extends Model
{
    protected $table = '{{ $table_name }}';
    protected $fillable = [];
    const TABLE_NAME = "{{ $table_name }}";
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
@foreach ($fields as $field)
@if($field->column_name != "id")
        "{{$field->column_name}}" => [
            "validation_add" => "required",
            "validation_edit" => "required",
            "searchable" => true,
            "sortable" => true,
            "filter" => false,
            "default" => "",
            "add" => true,
            "edit" => true,
            "get" => true,
            "find" => true
        ],
@endif
@endforeach
    ];

    public static function beforeInsert($input)
    {
        return $input;
    }

    public static function afterInsert($object)
    {
        Log::debug(json_encode($object));
    }

    public static function beforeUpdate($input)
    {
        return $input;
    }

    public static function afterUpdate($object)
    {
        Log::debug(json_encode($object));
    }
}
