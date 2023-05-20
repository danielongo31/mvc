<?php

    namespace Libs\Db;

    use PDO, PDOException;

    class Db {

        private static $instance;
        
        private $host;
        private $db;
        private $user;
        private $pass;
        private $charset;

        public function __construct()
        {
            $this->host = HOST;
            $this->db = DB;
            $this->user = USER;
            $this->pass = PASS;
            $this->charset = CHARSET;
        }

        public static function getInstance()
        {
            if (!isset(self::$instance)) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public function connect() : PDO
        {
            try{
                $con = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
                $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false];

                $pdo = new PDO($con, $this->user, $this->pass, $options);

                return $pdo;
            } catch(PDOException $e){
                error_log('Db::connect => ' . $e->getMessage());
                return null;
            }
        }
    }

?>