<?php

class HashController
{

    public static function save()
    {
        $response = Globals::getResponseArr();

        $params = Request::all();

        if (isset($params['url'])) {
            $url = filter_var(
                urldecode($params['url']),
                FILTER_VALIDATE_URL
            );
            $response = Hash::save($url);
        }

        return Response::json($response);
    }

}