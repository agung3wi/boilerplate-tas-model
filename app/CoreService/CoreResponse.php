<?php

namespace App\CoreService;

class CoreResponse
{

    public static function ok($output, $message = "")
    {
        $result["success"] = true;
        $result["result"] = $output;
        if (!is_null($message) && !empty($message)) {
            $result["message"] = $message;
        }

        return response()->json($result, 200);
    }

    public static function fail($ex)
    {
        $result["success"] = false;
        if (!empty($ex->getErrorMessage()) && !is_null($ex->getErrorMessage())) {
            $result["message"] = $ex->getErrorMessage();
        }

        return response()->json($result, $ex->getErrorCode());
    }

    public static function error($ex)
    {
        $result["success"] = false;
        if (!empty($ex->getErrorMessage()) && !is_null($ex->getErrorMessage())) {
            $result["error_message"] = $ex->getErrorMessage();
        }

        $result["error_code"] = $ex->getErrorCode();
        return response()->json($result, $ex->getErrorCode());
    }
}
