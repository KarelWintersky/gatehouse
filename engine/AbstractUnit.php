<?php

namespace Gatehouse;

class AbstractUnit
{
    const MYSQL_ERROR_DUPLICATE_ENTRY = 1062;

    public static function initResponse(array $with = [])
    {
        $default_response = [
            'error'     =>  -1,
            'errorMsg'  =>  '',
            'result'    =>  NULL
        ];

        return array_replace($default_response, $with);
    }
}