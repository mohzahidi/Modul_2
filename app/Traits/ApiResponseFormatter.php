<?php

namespace app\traits;

trait ApiResposeFormatter
{
    public function apiResponse($code = 200, $message = "success", $data = [])
    {
        return json_encode([
            "code" => $code,
            "message" => $message, 
            "data" => $data
        ]);
    }
}
