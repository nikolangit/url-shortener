<?php

class View
{

    public static function load(string $fileName, array $data = [])
    {
        require_once "public/view/{$fileName}.php";
        exit;
    }

}
