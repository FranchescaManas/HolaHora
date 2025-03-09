<?php

require_once "Database.php";

class Employee extends Database {

    public function shift($shift_type){

        $sql = "UPDATE users SET `online` = $shift_type";

        $result = $this->conn->query($sql);

        if(!$result){
            die("Error updating status. ". $this->conn->error);
        }
    }
}