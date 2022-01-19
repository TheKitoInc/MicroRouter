<?php

$path = explode('?', $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'], 2);
$path = $path[0];
//echo "<!--".$_SERVER['DOCUMENT_ROOT']."-->\n";
//echo "<!--".$path."-->\n";
while (strlen($path) > strlen($_SERVER['DOCUMENT_ROOT']) + 1) {
    //echo "<!-$path-->\n";
    $routerPath = $path . '/index.php';

    if (file_exists($routerPath)) {
        require_once($routerPath);
        return;
    }

    $path = dirname($path);
}