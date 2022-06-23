<?php

/**
 * Request handler.
 *
 * It handles request methods and functions.
 *
 * @copyright  Copyright (©) 2022 (https://nikolangit.github.io/)
 * @author     Nikola Nikolić <rogers94@gmail.com>
 * @link       https://nikolangit.github.io/
 */
class Request
{

    /**
     * It returns requested HTTP method.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @return string
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * It returns all requested values.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @return array
     */
    public static function all()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        return (array)$data;
    }

    /**
     * It returns URI.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @return string Request URI.
     */
    public static function uri()
    {
        return $_SERVER['REQUEST_URI'];
    }

}
