<?php

namespace Framework;

use App\Controllers\ErrorController;

class Router
{
    private $routes = [];

    public function registerRoute($method, $uri, $action)

    {
        list($controller, $controllerMethod) = explode('@', $action);
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
        ];
    }



    public function get($uri, $controller)
    {
        $this->registerRoute('GET', $uri, $controller, );
    }

    public function post($uri, $controller)
    {
        $this->registerRoute('POST', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        $this->registerRoute('PUT', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        $this->registerRoute('DELETE', $uri, $controller );
    }

    public function route($uri)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        //check for method input
        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            //override the request method with the value of _method
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach ($this->routes as $route) {
            //split the current URI into segments
            $uriSegments = explode('/', trim($uri, '/'));
            $routerSegments = explode('/', trim($route['uri'], '/'));
            $match = true;

            if (count($uriSegments) == count($routerSegments) && strtoupper($route['method']) === $requestMethod) {
                $params = [];
                $match = true;
                for ($i = 0; $i < count($uriSegments); $i++) {
                    //if the uri do not match and there is no value between the {param}
                    if ($routerSegments[$i] !== $uriSegments[$i] && !preg_match('/{(.*?)}/', $routerSegments[$i])) {
                        $match = false;
                        break;
                    }
                    //check for param and add to $params array
                    if (preg_match('/{(.*?)}/', $routerSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }
                if ($match) {
                    // Extract controller and controller method

                    $controller = 'App\\Controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];

                    // Instantiate controller class
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return;
                }
            }
        }
        ErrorController::notFound();
    }
}
