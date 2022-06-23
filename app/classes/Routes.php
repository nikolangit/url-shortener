<?php

/**
 * Routes handler.
 *
 * It handles route methods and functions.
 *
 * @copyright  Copyright (©) 2022 (https://nikolangit.github.io/)
 * @author     Nikola Nikolić <rogers94@gmail.com>
 * @link       https://nikolangit.github.io/
 */
class Routes
{

    /**
     * It test if the route matches defined conditions.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  string $path      Route path.
     * @param  string $method    HTTP method.
     * @param  string $classPath Class to be executed.
     * @return mixed
     */
    public static function test(string $path, string $method, string $classPath)
    {
        // Check if the HTTP method corresponds to the defined method type..
        if (Request::method() !== $method) {
            return;
        }

        // Request URI.
        $uri = Request::uri();

        $regex = '/^' . str_replace('/', '\\/', $path) . '$/';

        // Check if the URI matches the route path condition.
        if (preg_match($regex, $uri)) {
            $response = [];

            $classPathArr = explode('::', $classPath);

            $className  = $classPathArr[0];
            $methodName = $classPathArr[1];

            $response = $className::$methodName();

            // Check if it is the API request.
            if (str_starts_with($path, $uri)
                && str_starts_with($path, API_PATH)
            ) {
                Response::json($response);
            }

            return $response;
        }

        return;
    }

}
