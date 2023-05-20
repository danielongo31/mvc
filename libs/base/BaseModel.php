<?php

    class BaseModel 
    {

        private $db;

        public function __construct()
        {
            $this->db = Db::getInstance();
        }

        public function query(string $query){
            return $this->db->connect()->query($query);
        }

        public function prepare(string $query){
            return $this->db->connect()->prepare($query);
        }
        
    }

?>