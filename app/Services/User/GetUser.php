<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\CoreService\CoreException;
use App\CoreService\CoreService;


class GetUser extends CoreService
{

    public $transaction = false;
    public $task = "super-admin";

    public function prepare($input)
    {
        if (is_blank($input, "limit"))
            $input["limit"] = 10000;
        if (is_blank($input, "offset"))
            $input["offset"] = 0;

        $orderList = ['updated_at', 'role_id', 'username', 'name'];
        $sortList = ["ASC", "DESC"];
        if (is_blank($input, "order"))
            $input["order"] = "updated_at";

        if (is_blank($input, "sort"))
            $input["sort"] = "DESC";

        if (in_array($input["order"], $orderList))
            $input["order"] = "A.updated_at";

        if (in_array(strtoupper($input["sort"]), $sortList))
            $input["sort"] = "DESC";

        return $input;
    }

    public function process($input, $originalInput)
    {
        $params = [];
        $condition = "WHERE true";

        if (!is_blank($input, "src")) {
            $condition = $condition . " AND (";
            $condition = $condition . " A.username ILIKE :src";
            $condition = $condition . " OR A.name ILIKE :src";
            $condition = $condition . " OR A.email ILIKE :src";
            $condition = $condition . ")";
            $params["src"] = "%" . $input['src'] . "%";
        }

        if (!is_blank($input, "active")) {
            $condition = $condition . " AND A.active = :active";
            $params["active"] = $input["active"];
        };

        $total = DB::selectOne("SELECT COUNT(1) AS total
            FROM users A " .
            $condition, $params)->total;


        $sql = "SELECT A.*, null AS password, B.role_name
                FROM users A
            LEFT JOIN roles B ON B.id = A.role_id
            $condition
            ORDER BY " . $input['order'] . " " . $input['sort'] . " LIMIT :limit OFFSET :offset";

        $params["limit"] = $input["limit"];
        $params["offset"] = $input["offset"];

        $userList = DB::select($sql, $params);

        return [
            "items" => $userList,
            "total" => $total
        ];
    }

    protected function validation()
    {
        return [
            "limit" => "integer|min:0|max:1000",
            "offset" => "integer|min:0",
            "branch_id" => "integer"
        ];
    }
}
