<?php

class Request
{

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function get()
    {
        return $_GET;
    }

    public static function all()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        return (array)$data;
    }

    public static function uri()
    {
        return $_SERVER['REQUEST_URI'];
    }

}
