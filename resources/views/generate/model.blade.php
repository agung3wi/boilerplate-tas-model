
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class {{ $studly_caps }} extends Model
{
    protected $table = '{{ $table_name }}';
    const TABLE = "{{ $table_name }}";
    const IS_LIST = {{ $list? "true" : "false" }};
    const IS_ADD = {{ $add? "true" : "false" }};
    const IS_EDIT = {{ $edit? "true" : "false" }};
    const IS_DELETE = {{ $delete? "true" : "false" }};
    const IS_VIEW = {{ $view? "true" : "false" }};
    const FIELD_LIST = {!! arrayToString($fieldList) !!};
    const FIELD_ADD = {!! arrayToString($fieldAdd) !!};
    const FIELD_EDIT = {!! arrayToString($fieldEdit) !!};
    const FIELD_VIEW = {!! arrayToString($fieldView) !!};
    const FIELD_READONLY = {!! arrayToString($fieldReadonly) !!};
    const FIELD_FILTERABLE = {!! arrayToString($fieldFilterable) !!};
    const FIELD_SEARCHABLE = {!! arrayToString($fieldSearchable) !!};
    const FIELD_SORTABLE = {!! arrayToString($fieldSortable) !!};
    const FIELD_TYPE = [
@foreach($fieldType as $key => $type)
        "{{ $key }}" => "{{ $type }}",
@endforeach
    ];
    const FIELD_RELATION = [
@foreach($fieldRelation as $key => $relation)
        "{{ $key }}" => [
            "linkTable" => "{{ $relation["linkTable"] }}",
            "linkField" => "{{ $relation["linkField"] }}",
            "selectValue" => "{{ $relation["selectValue"] }}"
        ],
@endforeach
    ];
    const FIELD_VALIDATION = [
@foreach($fieldValidation as $key => $validation)
        "{{ $key }}" => "{{ $validation }}",
@endforeach
    ];
    const PARENT_CHILD = {!! arrayToString($parentChild) !!};

    public static function beforeInsert($input)
    {!! $before_insert !!}

    public static function afterInsert($object, $input)
    {!! $after_insert !!}
    
    public static function beforeUpdate($input)
    {!! $before_update !!}
    
    public static function afterUpdate($object, $input)
    {!! $after_update !!}
}
