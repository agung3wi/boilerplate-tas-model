<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Generating Model");
        if(env("DB_CONNECTION") == "pgsql") {
            $tables = DB::select("
            SELECT table_name FROM information_schema.tables 
            WHERE table_catalog = '" .  env("DB_DATABASE")  . "' AND table_schema='public'
            AND table_name NOT IN ('users', 'roles', 'tasks', 'role_task', 'jobs',
                'migrations', 'password_resets', 'failed_jobs')");
        } else if(env("DB_CONNECTION") == "mysql") {
            $tables = DB::select("
            SELECT table_name FROM information_schema.tables 
            WHERE table_schema = '" .  env("DB_DATABASE")  . "' AND table_name NOT IN ('users', 'roles', 'tasks', 'role_task', 'jobs',
                'migrations', 'password_resets', 'failed_jobs')");
        }

        $prefix = ["m_", "fi_", "in_", "pu_", "r_", "sl_"];
        foreach ($tables as $table) {
            $tableNameOriginal = $table->table_name;
            $tableName = $table->table_name;
            foreach ($prefix as $pre) {
                if (substr($tableName, 0, strlen($pre)) == $pre) {
                    $tableName = str_replace($pre, "", $tableName);
                }
            }
            $modelName = Str::ucfirst(Str::camel($tableName));
            $fileName = base_path("app/Models/" . $modelName . ".php");
            if(env("DB_CONNECTION") == "pgsql") {
                $sql = "
                WITH summary_fk AS (
                    select kcu.table_name as foreign_table,
                    rel_kcu.table_name as primary_table,
                    kcu.column_name as fk_column,
                    rel_kcu.column_name as pk_column,
                    pgc.confdeltype,
                    kcu.constraint_name
                from information_schema.table_constraints tco
                join information_schema.key_column_usage kcu
                        on tco.constraint_schema = kcu.constraint_schema
                        and tco.constraint_name = kcu.constraint_name
                join information_schema.referential_constraints rco
                        on tco.constraint_schema = rco.constraint_schema
                        and tco.constraint_name = rco.constraint_name
                join information_schema.key_column_usage rel_kcu
                        on rco.unique_constraint_schema = rel_kcu.constraint_schema
                        and rco.unique_constraint_name = rel_kcu.constraint_name
                        and kcu.ordinal_position = rel_kcu.ordinal_position
                join pg_constraint pgc ON pgc.conname = kcu.constraint_name
                where tco.constraint_type = 'FOREIGN KEY' AND kcu.constraint_catalog='".env("DB_DATABASE")."'
                    AND kcu.table_name = '$tableNameOriginal'
                order by kcu.table_schema,
                        kcu.table_name,
                        kcu.ordinal_position
                ), summary_comment AS (
                    SELECT
                        cols.column_name, cols.table_name, (
                            SELECT
                                pg_catalog.col_description(c.oid, cols.ordinal_position::int)
                            FROM
                                pg_catalog.pg_class c
                            WHERE
                                c.oid = (SELECT ('\"' || cols.table_name || '\"')::regclass::oid)
                                AND c.relname = cols.table_name
                        ) AS column_comment
                    FROM
                        information_schema.columns cols
                    WHERE
                        cols.table_catalog    = '" . env("DB_DATABASE") . "'
                        AND cols.table_name   = '$tableNameOriginal'
                ) SELECT A.column_name, A.data_type, A.character_maximum_length, B.primary_table AS ref_table, B.pk_column AS ref_column, C.column_comment 
                FROM information_schema.columns A 
                LEFT JOIN summary_fk B ON B.foreign_table = A.table_name AND 
                    B.fk_column = A.column_name 
                LEFT JOIN summary_comment C ON C.table_name = A.table_name AND C.column_name = A.column_name 
                WHERE A.table_catalog = '" . env("DB_DATABASE") . "' AND A.table_name = '$tableNameOriginal'";
            } elseif (env("DB_CONNECTION") == "mysql") {
                $sql = "SELECT A.column_name, A.data_type, A.character_maximum_length, B.ref_table, B.ref_column, A.column_comment 
                FROM information_schema.columns A
            LEFT JOIN (
                SELECT table_name,column_name, REFERENCED_TABLE_NAME AS ref_table, REFERENCED_COLUMN_NAME AS ref_column
                  FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                  WHERE table_schema='". env("DB_DATABASE") ."' AND table_name = '$tableNameOriginal' AND REFERENCED_TABLE_NAME IS NOT NULL
            ) B ON B.table_name = A.table_name AND B.column_name = A.column_name
            WHERE A.table_name = '$tableNameOriginal' AND A.table_schema = '". env("DB_DATABASE") ."'";
                
            }

            $fields = DB::select($sql);
            $fillableBackList = ["id", "created_at", "updated_at"];
            $fieldList = [];
            $fieldAdd = [];
            $fieldEdit = [];
            $fieldView = [];
            $fieldReadonly = [];
            $fieldFilterable = [];
            $fieldSearchable = [];
            $fieldSortable = [];
            $fieldType = [];
            $fieldValidation = [];
            $fieldRelation = [];
            $parentChild = [];
            
            foreach ($fields as $field) {    
                array_push($fieldList, $field->column_name);
                if(!in_array($field->column_name, $fillableBackList))
                    array_push($fieldAdd, $field->column_name);

                if(!in_array($field->column_name, $fillableBackList) && $field->column_name != "created_by")
                    array_push($fieldEdit, $field->column_name);

                array_push($fieldView, $field->column_name);
                array_push($fieldSortable, $field->column_name);

                if($field->data_type == "character varying" || $field->data_type == "text")
                    array_push($fieldSearchable, $field->column_name);

                if($field->data_type == "bigint" && !in_array($field->column_name, $fillableBackList))
                    array_push($fieldFilterable, $field->column_name);

                array_push($fieldFilterable, $field->column_name);
                $fieldType[$field->column_name] = $field->data_type;
                $fieldValidation[$field->column_name] = "";

                if($field->ref_table != null) {
                    $fieldRelation[$field->column_name] =  [
                        "linkTable" => $field->ref_table,
                        "linkField" => $field->ref_column,
                        "selectValue" => "*"
                    ];

                    if($field->column_name == "created_by") {
                        $fieldRelation[$field->column_name]["selectValue"] = "username AS created_username";
                    }

                    if($field->column_name == "updated_by") {
                        $fieldRelation[$field->column_name]["selectValue"] = "username AS updated_username";
                    }
                }
            }
            $beforeInsert = "\n        return \$input;\n    ";
            $beforeUpdate = "\n        return \$input;\n    ";
            $afterInsert = "\n        ";
            $afterUpdate = "\n        ";
            $params = [
                'list' => true,
                'add' => true,
                'edit' => true,
                'delete' => true,
                'view' => true,
                'fieldList' => $fieldList,
                'fieldAdd' => $fieldAdd,
                'fieldEdit' => $fieldEdit,
                'fieldView' => $fieldView,
                'fieldReadonly' => $fieldReadonly,
                'fieldFilterable' => $fieldFilterable,
                'fieldSearchable' => $fieldSearchable,
                'fieldSortable' => $fieldSortable,
                'fieldType' => $fieldType,
                'parentChild' => $parentChild,
                'fieldValidation' => $fieldValidation,
                'fieldRelation' => $fieldRelation,
                'table_name' => $tableNameOriginal,
                'studly_caps' => Str::ucfirst(Str::camel($tableName)),
                'before_insert' => "{" . $beforeInsert . "}",
                'after_insert' => "{" . $afterInsert . "}",
                'before_update' => "{" . $beforeUpdate . "}",
                'after_update' => "{" . $afterUpdate . "}"
            ];

            if (!is_file($fileName)) {
   
                $fileContent = view('generate.model', $params);
                file_put_contents($fileName, "<?php \n\n" . $fileContent);

                $this->info("Success Generate Model " . $modelName);
            } else {
                $contents = file_get_contents($fileName);
                // echo $contents;
                $classModel = "\\App\\Models\\" . $modelName;

                preg_match_all("/public static function beforeInsert\([\$]input\)\n    {([^}]*)}/", $contents, $matches);
                $beforeInsert = $matches[1][0];
                preg_match_all("/public static function afterInsert\([\$]object, [\$]input\)\n    {([^}]*)}/", $contents, $matches);
                $afterInsert = $matches[1][0];
                preg_match_all("/public static function beforeUpdate\([\$]input\)\n    {([^}]*)}/", $contents, $matches);
                $beforeUpdate = $matches[1][0];
                preg_match_all("/public static function afterUpdate\([\$]object, [\$]input\)\n    {([^}]*)}/", $contents, $matches);
                $afterUpdate = $matches[1][0];

                // Berubah Select Value Field Relation by coding
                foreach ($fieldRelation as $key => $relation) {
                    if(isset($classModel::FIELD_RELATION[$key]["selectValue"])) {
                        $fieldRelation[$key]["selectValue"] = $classModel::FIELD_RELATION[$key]["selectValue"];
                    }
                }

                $params = [
                    'list' => $classModel::IS_LIST,
                    'add' => $classModel::IS_ADD,
                    'edit' => $classModel::IS_EDIT,
                    'delete' => $classModel::IS_DELETE,
                    'view' => $classModel::IS_VIEW,
                    'fieldList' => $fieldList,
                    'fieldAdd' => $fieldAdd,
                    'fieldEdit' => $fieldEdit,
                    'fieldView' => $fieldView,
                    'fieldReadonly' => $fieldReadonly,
                    'fieldFilterable' => $fieldFilterable,
                    'fieldSearchable' => $fieldSearchable,
                    'fieldSortable' => $fieldSortable,
                    'fieldType' => $fieldType,
                    'parentChild' => $classModel::PARENT_CHILD,
                    'fieldValidation' => $fieldValidation,
                    'fieldRelation' => $fieldRelation,
                    'table_name' => $tableNameOriginal,
                    'studly_caps' => Str::ucfirst(Str::camel($tableName)),
                    'before_insert' => "{" . $beforeInsert . "}",
                    'after_insert' => "{" . $afterInsert . "}",
                    'before_update' => "{" . $beforeUpdate . "}",
                    'after_update' => "{" . $afterUpdate . "}"
                ];

                $fileContent = view('generate.model', $params);


                file_put_contents($fileName, "<?php \n\n" . $fileContent);
                $this->info("Success Modified Model " . $modelName);
            }
        }
    }
}
