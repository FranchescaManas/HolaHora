<?php

require_once "Database.php";

class Manager extends Database {
    
    public function get_team_employees(){
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT 
                    CONCAT(u.firstname, ' ', u.lastname) AS employee_name,
                    u.Status,
                    e.Position,
                    t.team_name
                FROM employees e
                JOIN users u ON e.user_id = u.user_id
                JOIN teams t ON e.team_id = t.team_id
                WHERE t.user_id = $user_id";
    
        $result = $this->conn->query($sql);
        if ($result) {
            return $result;
        } else {
            die("Error retrieving employees: " . $this->conn->error);
        }
    }

    public function search_employee($search) {
        $sql = "SELECT 
                    e.user_id,
                    e.position,
                    u.email,
                    CONCAT(u.firstname, ' ', u.lastname) AS name, 
                    u.status
                FROM 
                    employees e
                LEFT JOIN users u ON e.user_id = u.user_id
                WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' 
                ORDER BY firstname LIMIT 10";

        $result = $this->conn->query($sql); 

        // Check if query failed
        if (!$result) {
            die("Error in query: " . $this->conn->error); // Print the actual error
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<a href="#" class="dropdown-item employee-item" 
                data-id="'.$row['user_id'].'" 
                data-name="'.$row['name'].'" 
                data-position="'.$row['position'].'" 
                data-status="'.$row['status'].'">
                '.$row['name'].' ('.$row['position'].')
            </a>';
            }
        } else {
            echo '<a href="#" class="dropdown-item disabled">No results found</a>';
        }
    }

    public function add_employee_to_team($team_id, $user_id){
        $sql = "UPDATE employees SET `team_id` = $team_id WHERE `user_id` = $user_id";
        $result = $this->conn->query($sql);
    
        if (!$result) {
            die("Error adding employee to team: " . $this->conn->error);
        }
    }

    public function get_manager_teams(){
        $user_id = $_SESSION['user_id'];

        $sql = "SELECT * FROM teams WHERE user_id = $user_id";
    
        $result = $this->conn->query($sql);
        if ($result) {
            return $result;
        } else {
            die("Error retrieving employees: " . $this->conn->error);
        }
    }
    
}

?>