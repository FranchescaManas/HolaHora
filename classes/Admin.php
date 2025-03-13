<?php

require_once "Database.php";

class Admin extends Database {


    
    public function create_employee($request){
        // print_r($request);
        $username = $request['username'];
        $firstname = $request['firstname'];
        $lastname = $request['lastname'];
        $email = $request['lastname'];
        $contact_no = $request['contact'];
        $team_id = $request['team'];
        $position = $request['position'];
        $password = password_hash($request['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (`username`, `firstname`, `lastname`, `email`, `contact_no`, `password`, `role`, `status`, `admin_level`) VALUES ('$username', '$firstname', '$lastname', '$email', '$contact_no', '$password', 'Employee', 'Active', 0)";

        if($this->conn->query($sql)){


            // INSERT INTO 2nd table
            $user_id = $this->conn->insert_id;

            $sql = "INSERT INTO employees (`user_id`, `team_id`, `position`) VALUES ($user_id, $team_id, '$position')";

            if($this->conn->query($sql)){
                header("location: ../../views/admin/edit-team.php");
                exit;
            }
        }else{
            die("Error Registering Employee: " . $this->conn->error);
        }
    }

    // function 2.. etc etc
    public function create_manager($request) {
        // Extract and sanitize input
        $username = $request['username'];
        $password = password_hash($request['password'], PASSWORD_DEFAULT);
        $firstname = $request['firstname'];
        $lastname = $request['lastname'];
        $email = $request['email']; // Fix: Use email instead of lastname
        $contact_no = $request['contact'];
        
        // Check if team_id and department_id are set and not empty
        $team_id = isset($request['team']) && !empty($request['team']) ? (int) $request['team'] : null;
        $department_id = isset($request['department']) && !empty($request['department']) ? (int) $request['department'] : null;
    
        // Insert user into the users table
        $sql = "INSERT INTO users (`username`, `firstname`, `lastname`, `email`, `contact_no`, `password`, `role`, `status`, `admin_level`) 
                VALUES ('$username', '$firstname', '$lastname', '$email', '$contact_no', '$password', 'Manager', 'Active', 1)";
    
        if ($this->conn->query($sql)) {
            $user_id = $this->conn->insert_id; // Get the newly inserted user ID
    
            // Only insert into teams if team_id or department_id is provided
            if ($team_id !== null || $department_id !== null) {
                $sql_team = "INSERT INTO teams (`user_id`, `team_id`, `department_id`) 
                             VALUES ($user_id, " . ($team_id ?? 'NULL') . ", " . ($department_id ?? 'NULL') . ")";
                
                if (!$this->conn->query($sql_team)) {
                    die("Error assigning Manager to a team: " . $this->conn->error);
                }
            }
    
            // Redirect on success
            header("location: ../../views/admin/team-management.php");
            exit;
        } else {
            die("Error Registering Employee: " . $this->conn->error);
        }
    }
    

    public function create_department($request){
        $department = $request['department'];
        

        $sql = "INSERT INTO departments (`department_name`) VALUES ('$department')";

        if($this->conn->query($sql)){
            header("location: ../../views/admin/team-management.php");
            exit;
        }else{
            die("Error Registering Department: " . $this->conn->error);
        }
    }

    public function get_department(){
        $sql = "SELECT * FROM departments";

        if($result = $this->conn->query($sql)){
            return $result;
        } else{
            die("Error retrieving all departments: " . $conn->error);
        }
    }

    public function create_team($request){
        // TODO: Continue here
        $team_name = $request['team_name'];
        $status = $request['status'];
        $department_id = $request['department'];
        $user_id = $request['manager']; // user_id of the manager selected
        $sql = "INSERT INTO teams (`user_id`, `department_id`, `team_name`, `status`)
        VALUES ($user_id, $department_id, '$team_name', '$status')";

        if($this->conn->query($sql)){
            header("location: ../../views/admin/team-management.php");
            exit;
        } else{
            die("Error creating team: " . $this->conn->error);
        }

    }

    public function get_manager(){
        $sql = "SELECT * 
                FROM users  
                WHERE role = 'M';
                ";

        if($result = $this->conn->query($sql)){
            return $result;
        } else{
            die("Error retrieving all managers: " . $this->conn->error);
        }
    }

    public function get_teams(){
        $sql = "SELECT 
                t.team_id,
                t.team_name,
                concat(u.firstname, u.lastname) AS name,  -- Assuming `user_name` is the column for user names
                d.department_name AS department_name,  -- Assuming `department_name` is the column for department names
                t.status
            FROM 
                teams t
            LEFT JOIN users u ON t.user_id = u.user_id
            LEFT JOIN departments d ON t.department_id = d.department_id;";

        if($result = $this->conn->query($sql)){
            return $result;
        }else{
            die("Error retrieving teams table: " . $this->conn->error);
        }

    }

    public function delete_team($id){
        $sql = "DELETE from teams WHERE `team_id` = $id";

        if($this->conn->query($sql)){
            header("location: ../../views/admin/team-management.php");
            exit;
        } else{
            die("Error deleting team: " . $this->conn->error);
        }
    }

    public function create_activity($request){
        $activity_name = $request['activity_name'];
        $sql = "INSERT INTO activities (`activity_name`, `isBillable`) VALUES ('$activity_name', 1)";
        
        if($this->conn->query($sql)){
            header("location: ../../views/shared/dashboard.php");
            exit;
        } else{
            die("Error creating activity: " . $this->conn->error);
        }

    }


}

?>