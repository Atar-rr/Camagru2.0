<?php

namespace App\Src\Core;

/**
 * Class View
 * @package App\core
 */
class View
{
    const PATH_VIEW = __DIR__ . "/../View";

    /**
     * @param string $view
     * @param array $params
     */
    public function renderer(string $view, array $params = [])
    {
        $path = self::PATH_VIEW . $view;
        require_once $path;
        die();
    }

    /**
     * @param string $view
     * @param int $code
     */
    public function error(string $view, int $code)
    {
        http_response_code($code);
        $path = self::PATH_VIEW . $view;
        require_once $path;
        die();
    }
}