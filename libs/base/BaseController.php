<?php

    class BaseController
    {

        protected View $view;
        protected $model;

        public function __construct()
        {
            $this->view = new View();
        }

        public function getModel(string $model)
        {
            $url = 'models/' . ucfirst($model) . 'Model.php';
            error_log("BaseController::getModel => URL : " . $url);
            
            if (file_exists($url)){
                require_once $url;

                $modelName = $model . "Model";
                $this->model = new $modelName();
            }
        }

        public function existPost(array $params) : bool
        {
            foreach($params as $param){
                if (!isset($_POST[$param])){
                    error_log("BaseController::existPost => No existe el parametro: " . $param);
                    return false;
                }
            }

            return true;
        }

        public function existGet(array $params) : bool
        {
            foreach($params as $param){
                if (!isset($_GET[$param])){
                    error_log("BaseController::existPost => No existe el parametro: " . $param);
                    return false;
                }
            }

            return true;
        }

        public function getPost(string $name)
        {
            return $_POST[$name];
        }

        public function getGet(string $name)
        {
            return $_GET[$name];
        }

        public function redirect(string $route, array $msg){
            $data = [];
            $params = "";

            foreach($msg as $key => $msg){
                array_push($data, $key . "=" . $msg);
            }

            $params = join("&", $data);

            if ($params != ""){
                $params = "?" . $params;
            }

            header("Location: " . URL . $route . $params, true, 302);
        }

    }

?>