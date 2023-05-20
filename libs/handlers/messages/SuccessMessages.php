<?php

    namespace Libs\Handlers\Messages;

    class SuccessMessages {

        private $successList = [];

        public function __construct()
        {
            $this->successList = [
            ];
        }

        public function get(string $hash) : string
        {
            return $this->successList[$hash];
        }

        public function existsKey(string $key) : bool
        {
            if (array_key_exists($key, $this->successList)){
                return true;
            } else {
                return false;
            }
        }
    }

?>