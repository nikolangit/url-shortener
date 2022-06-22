<?php

class Response
{

    public static function json($jsonData)
    {
        header('Content-Type: application/json');
        die(json_encode($jsonData, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
    }

}
