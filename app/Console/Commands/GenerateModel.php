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
        $tables = DB::select("SELECT table_name FROM information_schema.tables
        WHERE table_catalog = '" .  env("DB_DATABASE")  . "' AND table_schema='public'
        AND table_name NOT IN ('users', 'roles', 'tasks', 'role_task', 'jobs',
            'migrations', 'password_resets', 'failed_jobs')");
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
            $fields = DB::select("SELECT * FROM information_schema.columns
            WHERE table_catalog = '" . env("DB_DATABASE") . "' AND table_name = '$tableNameOriginal'");

            $fieldConfigs = [];
            foreach ($fields as $field) {
                $fieldConfigs[$field->column_name] = [
                    "validation_add" => "",
                    "validation_edit" => "",
                    "searchable" => true,
                    "sortable" => true,
                    "filter" => false,
                    "filter_operation" => "",
                    "default" => "",
                    "add" => true,
                    "edit" => true,
                    "get" => true,
                    "find" => true
                ];
            }

            if (!is_file($fileName)) {
                $beforeInsert = "\n        return \$input;\n    ";
                $beforeUpdate = "\n        return \$input;\n    ";
                $afterInsert = "\n        ";
                $afterUpdate = "\n        ";
                $fileContent = view('generate.model', [
                    'add' => true,
                    'studly_caps' => $modelName,
                    'table_name' => $tableNameOriginal,
                    'before_insert' => "{" . $beforeInsert . "}",
                    'after_insert' => "{" . $afterInsert . "}",
                    'before_update' => "{" . $beforeUpdate . "}",
                    'after_update' => "{" . $afterUpdate . "}",
                    'fields' => $fieldConfigs
                ]);
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

                foreach ($classModel::FIELDS as $fieldName => $value) {
                    $fieldConfigs[$fieldName] = isset($fieldConfigs[$fieldName]) ?
                        $value : [
                            "validation_add" => "",
                            "validation_edit" => "",
                            "searchable" => true,
                            "sortable" => true,
                            "filter" => false,
                            "filter_operation" => "",
                            "default" => "",
                            "add" => true,
                            "edit" => true,
                            "get" => true,
                            "find" => true
                        ];
                }

                $fileContent = view('generate.model', [
                    'add' => $classModel::ADD,
                    'before_insert' => "{" . $beforeInsert . "}",
                    'after_insert' => "{" . $afterInsert . "}",
                    'before_update' => "{" . $beforeUpdate . "}",
                    'after_update' => "{" . $afterUpdate . "}",
                    'studly_caps' => $modelName,
                    'table_name' => $tableNameOriginal,
                    'fields' => $fieldConfigs
                ]);


                file_put_contents($fileName, "<?php \n\n" . $fileContent);
                $this->info("Success Modified Model " . $modelName);
            }
        }
    }
}
