<?php

class Route
{
    static function start() : void
    {
        $controller_name = 'Main';
        $action_name = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);
        debug($routes);

        if (!empty($routes[1]))
        {
            $controller_name = $routes[1];
        }

        if (!empty($routes[2]))
        {
            $action_name = $routes[2];
        }

        $model_name = 'Model_' . $controller_name;
        $controller_name = 'Controller_' . $controller_name;
        $action_name = 'action' . $action_name;

        $model_file = strtolower($model_name) . '.php';
        $model_path = 'app/models/' . $model_file;

        if (file_exists($model_path))
        {
            include $model_path;
        }

        $controller_file = strtolower($controller_name) . '.php';
        $controller_path = 'app/controllers/' . $controller_file;

        if (file_exists($controller_path))
        {
            include $controller_path;
        }
        else
        {
              Route::ErrorPage404();
        }

        $controller = new $controller_name;
        $action = $action_name;

        if(method_exists($controller, $action))
        {
            $controller->$action();
        }
        else
        {
            Route::ErrorPage404();
        }
    }

    private static function ErrorPage404() : void
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }
}