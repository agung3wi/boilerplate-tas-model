<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InitTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $data = [
            [
                "task_group" => "SUPER ADMIN",
                "task_code" => "super-admin",
                "task_name" => "Super Admin",
                "description" => "Role Untuk Super Admin Bisa Apa Aja"
            ],
            ///////// USERS //////////////
            [
                "task_group" => "USERS",
                "task_code" => "view-users",
                "task_name" => "View Users",
                "description" => "Melihat Data List, Detail, Lookup Users "
            ],
            [
                "task_group" => "USERS",
                "task_code" => "create-users",
                "task_name" => "create Users",
                "description" => "Membuat Data Users "
            ],
            [
                "task_group" => "USERS",
                "task_code" => "update-users",
                "task_name" => "update Users",
                "description" => "Mengubah Data Users "
            ],
            [
                "task_group" => "USERS",
                "task_code" => "delete-users",
                "task_name" => "delete Users",
                "description" => "Menghapus Data Users "
            ],

            ///////// ROLES //////////////
            [
                "task_group" => "ROLES",
                "task_code" => "view-roles",
                "task_name" => "View Roles",
                "description" => "Melihat Data List, Detail, Lookup Roles "
            ],
            [
                "task_group" => "ROLES",
                "task_code" => "create-roles",
                "task_name" => "create Roles",
                "description" => "Membuat Data Roles "
            ],
            [
                "task_group" => "ROLES",
                "task_code" => "update-roles",
                "task_name" => "update Roles",
                "description" => "Mengubah Data Roles "
            ],
            [
                "task_group" => "ROLES",
                "task_code" => "delete-roles",
                "task_name" => "delete Roles",
                "description" => "Menghapus Data Roles "
            ],
            ///////// DEPARTMENTS //////////////
            [
                "task_group" => "DEPARTMENTS",
                "task_code" => "view-departments",
                "task_name" => "View departments",
                "description" => "Melihat Data List, Detail, Lookup departments "
            ],
            [
                "task_group" => "DEPARTMENTS",
                "task_code" => "create-departments",
                "task_name" => "create departments",
                "description" => "Membuat Data departments "
            ],
            [
                "task_group" => "DEPARTMENTS",
                "task_code" => "update-departments",
                "task_name" => "update departments",
                "description" => "Mengubah Data departments "
            ],
            [
                "task_group" => "DEPARTMENTS",
                "task_code" => "delete-departments",
                "task_name" => "delete departments",
                "description" => "Menghapus Data departments "
            ],
            ///////// DIVISIONS //////////////
            [
                "task_group" => "DIVISIONS",
                "task_code" => "view-divisions",
                "task_name" => "View divisions",
                "description" => "Melihat Data List, Detail, Lookup divisions "
            ],
            [
                "task_group" => "DIVISIONS",
                "task_code" => "create-divisions",
                "task_name" => "create divisions",
                "description" => "Membuat Data divisions "
            ],
            [
                "task_group" => "DIVISIONS",
                "task_code" => "update-divisions",
                "task_name" => "update divisions",
                "description" => "Mengubah Data divisions "
            ],
            [
                "task_group" => "DIVISIONS",
                "task_code" => "delete-divisions",
                "task_name" => "delete divisions",
                "description" => "Menghapus Data divisions "
            ],
            ///////// PROJECTS //////////////
            [
                "task_group" => "PROJECTS",
                "task_code" => "view-projects",
                "task_name" => "View projects",
                "description" => "Melihat Data List, Detail, Lookup projects "
            ],
            [
                "task_group" => "PROJECTS",
                "task_code" => "create-projects",
                "task_name" => "create projects",
                "description" => "Membuat Data projects "
            ],
            [
                "task_group" => "PROJECTS",
                "task_code" => "update-projects",
                "task_name" => "update projects",
                "description" => "Mengubah Data projects "
            ],
            [
                "task_group" => "PROJECTS",
                "task_code" => "delete-projects",
                "task_name" => "delete projects",
                "description" => "Menghapus Data projects "
            ],
            ///////// QHSE NC IMPACT ANALYSIS //////////////
            [
                "task_group" => "QHSE NC IMPACT ANALYSIS",
                "task_code" => "view-qhse_nc_impact_analysis",
                "task_name" => "View QHSE NC Impact Analysis",
                "description" => "Melihat Data List, Detail, Lookup QHSE NC Impact Analysis "
            ],
            [
                "task_group" => "QHSE NC IMPACT ANALYSIS",
                "task_code" => "create-qhse_nc_impact_analysis",
                "task_name" => "create QHSE NC Impact Analysis",
                "description" => "Membuat Data QHSE NC Impact Analysis "
            ],
            [
                "task_group" => "QHSE NC IMPACT ANALYSIS",
                "task_code" => "update-qhse_nc_impact_analysis",
                "task_name" => "update QHSE NC Impact Analysis",
                "description" => "Mengubah Data QHSE NC Impact Analysis "
            ],
            [
                "task_group" => "QHSE NC IMPACT ANALYSIS",
                "task_code" => "delete-qhse_nc_impact_analysis",
                "task_name" => "delete QHSE NC Impact Analysis",
                "description" => "Menghapus Data QHSE NC Impact Analysis "
            ],
            ///////// QHSE NC CRITERIAS //////////////
            [
                "task_group" => "QHSE NC CRITERIAS",
                "task_code" => "view-qhse_nc_criterias",
                "task_name" => "View QHSE NC Criterias",
                "description" => "Melihat Data List, Detail, Lookup QHSE NC Criterias "
            ],
            [
                "task_group" => "QHSE NC CRITERIAS",
                "task_code" => "create-qhse_nc_criterias",
                "task_name" => "create QHSE NC Criterias",
                "description" => "Membuat Data QHSE NC Criterias "
            ],
            [
                "task_group" => "QHSE NC CRITERIAS",
                "task_code" => "update-qhse_nc_criterias",
                "task_name" => "update QHSE NC Criterias",
                "description" => "Mengubah Data QHSE NC Criterias "
            ],
            [
                "task_group" => "QHSE NC CRITERIAS",
                "task_code" => "delete-qhse_nc_criterias",
                "task_name" => "delete QHSE NC Criterias",
                "description" => "Menghapus Data QHSE NC Criterias "
            ],

            ///////// VALSALS //////////////
            [
                "task_group" => "VALSALS",
                "task_code" => "view-valsals",
                "task_name" => "View Valsals",
                "description" => "Melihat Data List, Detail, Lookup Valsals "
            ],
            [
                "task_group" => "VALSALS",
                "task_code" => "create-valsals",
                "task_name" => "create Valsals",
                "description" => "Membuat Data Valsals "
            ],
            [
                "task_group" => "VALSALS",
                "task_code" => "update-valsals",
                "task_name" => "update Valsals",
                "description" => "Mengubah Data Valsals "
            ],
            [
                "task_group" => "VALSALS",
                "task_code" => "delete-valsals",
                "task_name" => "delete Valsals",
                "description" => "Menghapus Data Valsals "
            ],

            ///////// BOCAL CAUSE TYPES //////////////
            [
                "task_group" => "BOCAL CAUSE TYPES",
                "task_code" => "view-bocal_cause_types",
                "task_name" => "View BOCAL Cause Types",
                "description" => "Melihat Data List, Detail, Lookup BOCAL Cause Types "
            ],
            [
                "task_group" => "BOCAL CAUSE TYPES",
                "task_code" => "create-bocal_cause_types",
                "task_name" => "create BOCAL Cause Types",
                "description" => "Membuat Data BOCAL Cause Types "
            ],
            [
                "task_group" => "BOCAL CAUSE TYPES",
                "task_code" => "update-bocal_cause_types",
                "task_name" => "update BOCAL Cause Types",
                "description" => "Mengubah Data BOCAL Cause Types "
            ],
            [
                "task_group" => "BOCAL CAUSE TYPES",
                "task_code" => "delete-bocal_cause_types",
                "task_name" => "delete BOCAL Cause Types",
                "description" => "Menghapus Data BOCAL Cause Types "
            ],
            ///////// STATUS CODE //////////////
            [
                "task_group" => "STATUS CODE",
                "task_code" => "view-status_code",
                "task_name" => "View Status Code",
                "description" => "Melihat Data List, Detail, Lookup Status Code "
            ],
            [
                "task_group" => "STATUS CODE",
                "task_code" => "create-status_code",
                "task_name" => "create Status Code",
                "description" => "Membuat Data Status Code "
            ],
            [
                "task_group" => "STATUS CODE",
                "task_code" => "update-status_code",
                "task_name" => "update Status Code",
                "description" => "Mengubah Data Status Code "
            ],
            [
                "task_group" => "STATUS CODE",
                "task_code" => "delete-status_code",
                "task_name" => "delete Status Code",
                "description" => "Menghapus Data Status Code "
            ]
        ];
        DB::table('tasks')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
