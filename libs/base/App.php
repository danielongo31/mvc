<?php

    class App
    {
        
        private string $version;
        
        public function __construct()
        {
            $this->init();
            $this->version = date('Y-m-d');
        }

        private function init()
        {
            $route = $this->getRoute();

            if (empty($route['controller'])) {
                $this->getDefaultPage();
                return;
            }

            $this->startController($route['controller'], $route['method'], $route['params']);
        }

        protected function getDefaultPage()
        {
            require 'controllers/Auth.php';

            $controller = new Auth();
            $controller->getModel('Auth');
            $controller->render();
        }

        protected function getRoute(): array
        {
            $url = isset($_GET["url"]) ? $_GET["url"] : null;
            $url = isset($url) ? rtrim($url, "/") : "";
            $url = explode("/", $url);

            $params = [];
            $method = '';

            if (isset($url[1])) {
                $method = $url[1];
            }

            if (isset($url[2])) {
                $params = $this->getParams($url);
            }

            return array('controller' => ucwords($url[0]), 'method' => $method, 'params' => $params);
        }

        protected function getParams(array $url) : array
        {
            $nParam = count($url) - 2;
            $params = [];

            for($i = 0; $i < $nParam; $i++){
                array_push($params, $url[$i+2]);
            }

            return $params;
        }

        protected function startController(string $name, string $method = null, array $params = [])
        {
            $path = 'controllers/' . $name . '.php';

            if (file_exists($path)){
                require $path;

                $controller = new $name();
                $controller->getModel($name);

                if ($method != null) {
                    if (method_exists($controller, $method)) {
                        if (count($params) > 0) {
                            $controller->{$method}($params);
                        } else {
                            $controller->{$method}();
                        }
                    } else {
                        require_once 'controllers/Errores.php';
                        $controller = new Errores();
                        $controller->render();
                    }
                } else {
                    $controller->render();
                }
            } else if ($name != 'Assets') {
                require_once 'controllers/Errores.php';
                $controller = new Errores();
                $controller->render();
            }
        }

        public function getVersion() : string { return $this->version; }

    }

?>