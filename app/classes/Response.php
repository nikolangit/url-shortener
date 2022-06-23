<?php

/**
 * Response handler.
 *
 * It handles response methods and functions.
 *
 * @copyright  Copyright (©) 2022 (https://nikolangit.github.io/)
 * @author     Nikola Nikolić <rogers94@gmail.com>
 * @link       https://nikolangit.github.io/
 */
class Response
{

    /**
     * It returns JSON as respose..
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  array $jsonData JSON data.
     * @return json
     */
    public static function json($jsonData)
    {
        header('Content-Type: application/json');
        die(json_encode($jsonData, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
    }

}
