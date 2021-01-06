<?php

namespace Core;

class App
{
    public static function run()
    {
        $path = $_SERVER['REQUEST_URI'];
        $pathParts = explode('/', $path);

        $controller = $pathParts[1];

        $pathParts2 = explode('?', $pathParts[2]);
        $action = $pathParts2[0];

        $controller = 'Controllers\\' . $controller . 'Controller';
        $action = 'action' . ucfirst($action);

        if (!class_exists($controller)) {
            throw new \ErrorException('Controller does not exist');
        }

        $objController = new $controller;

        if (!method_exists($objController, $action)) {
            throw new \ErrorException('Action does not exist');
        }

        $objController->$action();
    }
}