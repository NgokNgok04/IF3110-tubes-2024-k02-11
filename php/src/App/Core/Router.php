<?php

namespace App\Core;
use App\Core\Controller;

class Router
{

    protected $routes = [];

    private function addRoute($route, $controller, $action, $method, $roles = [])
    {
        $this->routes[$method][$route] = [
            'controller' => $controller,
            'action' => $action,
            'roles' => $roles
        ];
    }

    public function get($route, $controller, $action, $roles = [])
    {
        $this->addRoute($route, $controller, $action, "GET", $roles);
    }

    public function post($route, $controller, $action, $roles = [])
    {
        $this->addRoute($route, $controller, $action, "POST", $roles);
    }

    public function PUT($route, $controller, $action, $roles = [])
    {
        $this->addRoute($route, $controller, $action, "PUT", $roles);
    }

    public function patch($route, $controller, $action, $roles = [])
    {
        $this->addRoute($route, $controller, $action, "PATCH", $roles);
    }

    public function delete($route, $controller, $action, $roles = [])
    {
        $this->addRoute($route, $controller, $action, "DELETE", $roles);
    }

    public function options($route, $controller, $action, $roles = [])
    {
        $this->addRoute($route, $controller, $action, "OPTIONS", $roles);
    }

    public function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];
        $currentRole = $_SESSION['role'] ?? 'unauthorized';

        foreach ($this->routes[$method] as $route => $data) {
            // Ubah route yang memiliki parameter seperti {id}
            $routeRegex = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);
            $routeRegex = "#^" . $routeRegex . "$#";

            if (preg_match($routeRegex, $uri, $matches)) {
                array_shift($matches); // Hilangkan full match dari hasil regex

                $controller = $data['controller'];
                $action = $data['action'];
                $allowedRoles = $data['roles'];

                // Periksa apakah role pengguna sesuai dengan allowedRoles
                if (empty($allowedRoles) || in_array($currentRole, $allowedRoles)) {
                    $controller = new $controller();

                    // Panggil action dengan parameter yang ditemukan (seperti {id})
                    call_user_func_array([$controller, $action], $matches);
                    return;
                } else {
                    $err = new Controller(); 
                    if($currentRole == 'unauthorized') {
                        $err->view('Error', 'NoAccess', []);
                    } else if($currentRole == 'JobSeeker') {
                        $err->view('Error', 'NoAccessCompany', []);
                    } else if($currentRole == 'Company') {
                        $err->view('Error', 'NoAccessJobSeeker', []);
                    }
                    echo "<script>
                            setTimeout(function(){
                                window.location.href = '/';
                            }, 5000);
                          </script>";
                    return;
                }
            }
        }

        echo "Not Found";
    }
}
