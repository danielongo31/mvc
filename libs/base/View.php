<?php

    class View
    {

        protected $d;
        protected string $username;

        public function __construct()
        {
            $this->username = '';
        }

        public function render(string $name, array $data = [])
        {
            $this->d = $data;

            $this->handleMessages();

            require dirname(__DIR__, 2) . '/views/' . $name . ".php";
        }

        public function handleMessages()
        {
            if (isset($_GET["success"]) && isset($_GET["error"])){

            } else if (isset($_GET["success"])){
                $this->handleSuccess();
            } else if (isset($_GET["error"])){
                $this->handleError();
            }
        }
        
        public function handleError()
        {
            $hash = $_GET["error"];
            $error = new ErrorMessages();

            if ($error->existsKey($hash)){
                $this->d["error"] = $error->get($hash);
            }
        }

        public function handleSuccess()
        {
            $hash = $_GET["success"];
            $success = new SuccessMessages();

            if ($success->existsKey($hash)){
                $this->d["success"] = $success->get($hash);
            }
        }

        public function showMessages()
        {
            $this->showErrors();
            $this->showSuccess();
        }

        public function showErrors()
        {
            if (array_key_exists("error", $this->d)){
                echo "<div class='error'>".$this->d["error"]."</div>";
            }
        }

        public function showSuccess()
        {
            if (array_key_exists("success", $this->d)){
                echo "<div class='success'>".$this->d["success"]."</div>";
            }
        }

        public function setUsername(string $username) { $this->username = $username; }
    }

?>