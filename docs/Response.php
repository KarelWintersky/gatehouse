<?php


namespace Arris;

class Answer
{
    public static $default_response = [
        'error'     =>  -1,
        'errorMsg'  =>  '',
        'result'    =>  NULL
    ];

    public static function init(array $with = [])
    {
        self::$default_response = array_replace(self::$default_response, $with);
    }

    public static function setError(\Exception $exception)
    {
        self::$default_response['error'] = $exception->getCode();
        self::$default_response['errorMsg'] = $exception->getMessage();
    }

    /**
     * @return array
     */
    public static function get()
    {
        return self::$default_response;
    }


}