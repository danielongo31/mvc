<?php

    namespace Libs\Handlers\Messages;

    class ErrorMessages {

        private $errorList = [];

        public function __construct()
        {
            $this->errorList = [
            ];
        }

        public function get(string $hash) : string
        {
            return $this->errorList[$hash];
        }

        public function existsKey(string $key) : bool
        {
            if (array_key_exists($key, $this->errorList)){
                return true;
            } else {
                return false;
            }
        }
    }

?>