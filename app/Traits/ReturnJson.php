<?php

namespace App\Traits;

trait ReturnJson 
{
    protected function returnJsonSuccess($msg = [])
    {
        $result = [
            'success' => true,
            'code' => 200
        ];
        $result = array_merge($result, $msg);
        return response()->json($result);
    }

    protected function returnJsonFailed($msg = [])
    {
        $result = [
            'success' => false,
            'code' => 400
        ];
        $result = array_merge($result, $msg);
        return response()->json($result);
    }

}