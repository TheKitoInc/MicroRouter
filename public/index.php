<?php

namespace Kito\MicroServices;

class MicroRouter
{

    public function __construct()
    {
        ob_start();

        $SITE_ROOT = realpath(self::parsePath(filter_input(INPUT_SERVER, 'DOCUMENT_ROOT')));
//error_log($SITE_ROOT);

        $REQUEST_PATH = self::parsePath(self::removeArgs(filter_input(INPUT_SERVER, 'REQUEST_URI')));
//error_log($REQUEST_PATH);

        $PATH = self::parsePath($SITE_ROOT . DIRECTORY_SEPARATOR . $REQUEST_PATH);
//error_log($PATH);


        while (strlen($PATH) > strlen($_SERVER['DOCUMENT_ROOT']) + 1)
        {
            $routerPath = $PATH . '/index.php';

            if (file_exists($routerPath))
            {
                ob_clean();
                require_once($routerPath);
                return;
            }

            $PATH = dirname($PATH);
        }
    }

    private static function removeArgs(string $path): string
    {
        $elements = explode('?', $path, 2);
        return $elements[0];
    }

    private static function parsePath(string $path): string
    {
        $elements = array();
        foreach (explode(DIRECTORY_SEPARATOR, str_replace("\\", DIRECTORY_SEPARATOR, str_replace('/', DIRECTORY_SEPARATOR, $path))) as $element)
        {
            if (empty($element))
                continue;

            if ($element == '.')
                continue;

            if ($element == '..')
                array_pop($elements);

            $elements[] = $element;
        }

        return implode(DIRECTORY_SEPARATOR, $elements);
    }

}

new MicroRouter();