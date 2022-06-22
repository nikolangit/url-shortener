<?php

class PagesController
{

    public static function home()
    {
        $response = Globals::getResponseArr();

        return View::load('home', $response);
    }

    public static function load()
    {
        $response = Globals::getResponseArr();

        $hash = substr(Request::uri(), 1, 8);

        $hashData = Hash::get($hash);

        if (empty($hashData)) {
            $response['error'] = 'Hash doesn\'t exists.';
            View::load('home', $response);
        }

        Hash::update($hash);

        $response = array_merge(
            $response,
            $hashData
        );

        View::load('load', $response);
    }

}
