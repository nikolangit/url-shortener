<?php

class Routes
{

    public static function test(string $path, string $method, string $classPath)
    {
        if (Request::method() === $method) {
            $uri = Request::uri();
    
            $regex = '/^' . str_replace('/', '\\/', $path) . '$/';
    
            if (preg_match($regex, $uri)) {
                $response = [];
        
                $classPathArr = explode('::', $classPath);
        
                $className  = $classPathArr[0];
                $methodName = $classPathArr[1];
        
                $response = $className::$methodName();

                if (str_starts_with($path, $uri)
                    && str_starts_with($path, API_PATH)
                ) {
                    Response::json($response);
                }

                return $response;
            }
        }

        return;
    }

}
