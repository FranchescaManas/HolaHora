<?php

    class Database {
        private $server_name = "localhost";
        private $db_username = "don";
        private $db_password = "1M@gic123456!";
        private $db_name = "don_hola_hora";

        public function __construct(){
            $this->conn = new mysqli($this->server_name, $this->db_username, $this->db_password, $this->db_name);

            if($this->conn->connect_error){
                die("Unable to connect to database " . $this->db_name . " : ". $this->conn->connect_error);
            }
        }
    }

?>