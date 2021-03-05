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
        WHERE table_catalog = 'boilerplate-model' AND table_schema='public'
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
            if (!is_file($fileName)) {
                $fileContent = view('generate.model', [
                    'studly_caps' => $modelName,
                    'table_name' => $tableNameOriginal,
                    'fields' => DB::select("SELECT * FROM information_schema.columns
                        WHERE table_catalog = 'boilerplate-model' AND table_name = '$tableNameOriginal'")
                ]);
                file_put_contents($fileName, "<?php \n\n".$fileContent);

                $this->info("Success Generate Model " . $modelName);
            }
        }
    }
}
