<?php

/**
 * Views handler.
 *
 * It handles view methods and functions.
 *
 * @copyright  Copyright (©) 2022 (https://nikolangit.github.io/)
 * @author     Nikola Nikolić <rogers94@gmail.com>
 * @link       https://nikolangit.github.io/
 */
class View
{

    /**
     * It loads a template.
     *
     * @author Nikola Nikolić <rogers94@gmail.com>
     * @param  string $fileName Template filename to load.
     * @param  array  $data     Data to be passed at template.
     * @return mixed
     */
    public static function load(string $fileName, array $data = [])
    {
        require_once "public/view/{$fileName}.php";
        exit;
    }

}
