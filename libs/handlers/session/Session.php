<?php

    class Session {
        
        protected $sessionName = "electro/user";

        public function __construct()
        {
            if (session_status() == PHP_SESSION_NONE){
                session_start();
            }
        }

        public function setCurrentUser($account)
        {
            $_SESSION[$this->sessionName] = $account->getEmail();
        }

        public function getCurrentUser()
        {
            if ($this->exists()){
                return $_SESSION[$this->sessionName];
            }
        }

        public function closeSession()
        {
            session_unset();
            session_destroy();
        }

        public function exists() : bool
        {
            return isset($_SESSION[$this->sessionName]);
        }

        protected function setSessionName(string $sessionName) { $this->sessionName = $sessionName; }
    }

?>