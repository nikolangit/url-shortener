<?php

/**
 * Pages handler.
 *
 * It handles page methods and functions.
 *
 * @copyright  Copyright (©) 2022 (https://nikolangit.github.io/)
 * @author     Nikola Nikolić <rogers94@gmail.com>
 * @link       https://nikolangit.github.io/
 */
class PagesController
{

    /**
     * It previews homepage.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  void
     * @return void
     */
    public static function home()
    {
        $ret = Globals::getResponseArr();

        View::load('home', $ret);
    }

    /**
     * It previews page for loading URL's.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  void
     * @return void
     */
    public static function load()
    {
        $ret = Globals::getResponseArr();

        $hash = substr(Request::uri(), 1, 8);

        $hashData = Hash::get($hash);

        if (empty($hashData)) {
            $ret['error'] = 'Hash doesn\'t exists.';
            View::load('home', $ret);
        }

        Hash::update($hash);

        $ret = array_merge(
            $ret,
            $hashData
        );

        View::load('load', $ret);
    }

}
