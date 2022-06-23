<?php

/**
 * ___ handler.
 *
 * It handles ___ methods and functions.
 *
 * @copyright  Copyright (©) 2022 (https://nikolangit.github.io/)
 * @author     Nikola Nikolić <rogers94@gmail.com>
 * @link       https://nikolangit.github.io/
 */
class HashController
{

    /**
     * It saves URL to the database.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  void
     * @return json
     */
    public static function save()
    {
        $ret = Globals::getResponseArr();

        $params = Request::all();

        if (isset($params['url']) && strlen($params['url'] >= 15)) {
            $url = filter_var(
                urldecode($params['url']),
                FILTER_VALIDATE_URL
            );
            $ret = Hash::save($url);
        }

        Response::json($ret);
    }

    /**
     * It .
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  void
     * @return json
     */
    public static function delete()
    {
        Hash::truncate();

        $ret = Globals::getResponseArr();

        Response::json($ret);
    }

}
