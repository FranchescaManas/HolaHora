<?php

require_once "Database.php";

class User extends Database {

    public function login($request){
        $username = $request['username'];
        $password = $request['password'];

        $sql = "SELECT * FROM users WHERE `username` = '$username'";
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc(); // Fetch user data
            
            // Verify the hashed password
            if (password_verify($password, $user['password'])) {
                session_start();
                // Store user info in session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                $sql = "UPDATE `users` SET `online` = 1 WHERE `user_id` = " . $user['user_id'];

                if($this->conn->query($sql)){

                    // Redirect based on role
                    if ($user['role'] == 'A') {
                        header('Location: ../../views/shared/dashboard.php');
                    } else if ($user['role'] == 'M'){
                        header('Location: ../../views/shared/dashboard.php'); // Adjust for other roles
                    } else{
                        header('Location: ../../views/employee/activity.php');
                    }
                    exit;
                }else{
                    die("Error setting user status to online. " . $this->conn->error);
                }
            } else {
                echo "Invalid password!";
            }
        } else {
            echo "User not found!";
        }
    }

    public function logout(){
        session_start();
        $user_id = $_SESSION['user_id'];
        $sql = "UPDATE `users` SET `online` = 1 WHERE `user_id` = $user_id";

        if($this->conn->query($sql)){

            session_unset();
            session_abort();
            session_destroy();
            
            header('Location: ../../views/');
            exit;
        }else{
            die("Error setting user status to online. " . $this->conn->error);
        }
    }

    public function get_profile(){
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM users WHERE `user_id` = $user_id";

        if($result = $this->conn->query($sql)){
            return $result->fetch_assoc();
        }else{
            die("Error retreiving user details. ". $this->conn->error);
        }
        
        
    }

    public function get_activity(){
        $sql = "SELECT * FROM activities";

        if($result = $this->conn->query($sql)){
            return $result;
        }else{
            die("Error retrieving activities table: " . $this->conn->error);
        }

    }

    public function get_activity_hours() {
        $user_id = $_SESSION['user_id'];
        $role = $_SESSION['role'];
        
        if($role == 'E'){

            $sql = "SELECT 
                        a.activity_name,
                        ROUND(SUM(ABS(TIMESTAMPDIFF(SECOND, te.start_time, te.end_time))) / 3600, 2) AS total_hours
                    FROM time_entries te
                    JOIN activities a ON te.activity_id = a.activity_id
                    WHERE te.end_time IS NOT NULL 
                    AND te.start_time BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') 
                                        AND LAST_DAY(CURDATE())
                    AND te.employee_id = $user_id
                    GROUP BY a.activity_id, a.activity_name
                    ORDER BY a.activity_name";
        }elseif($role == 'A'){
            $sql = "SELECT 
                        a.activity_name,
                        ROUND(SUM(ABS(TIMESTAMPDIFF(SECOND, te.start_time, te.end_time))) / 3600, 2) AS total_hours
                    FROM time_entries te
                    JOIN activities a ON te.activity_id = a.activity_id
                    WHERE te.end_time IS NOT NULL 
                    AND te.start_time BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') 
                                        AND LAST_DAY(CURDATE())
                    GROUP BY a.activity_id, a.activity_name
                    ORDER BY a.activity_name";
        }elseif($role == 'M'){
            $sql = "SELECT 
                        act.activity_name,
                        ROUND(SUM(ABS(TIMESTAMPDIFF(SECOND, te.start_time, te.end_time))) / 3600, 2) AS total_hours
                    FROM time_entries te
                    JOIN activities act ON te.activity_id = act.activity_id
                    JOIN employees e ON te.employee_id = e.user_id
                    JOIN teams t ON e.team_id = t.team_id
                    WHERE te.end_time IS NOT NULL 
                    AND t.user_id = $user_id
                    AND te.start_time BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') 
                                        AND LAST_DAY(CURDATE())
                    GROUP BY act.activity_id, act.activity_name
                    ORDER BY act.activity_name";
        }
    
        $result = $this->conn->query($sql);
    
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = [$row['activity_name'], (float)$row['total_hours']]; // Convert total_hours to float
            }
        } else {
            die("Error retrieving time entry data: " . $this->conn->error);
        }
    
        return $data;
    }
    
    // TODO: Fix nagative values when another day starts
    public function get_activity_dashboard() {
        $user_id = $_SESSION['user_id'];
        $role = $_SESSION['role'];
        if($role == 'E'){
            $sql = "SELECT entry_id, activity_name, start_time, end_time, TIMEDIFF(end_time, start_time) AS duration
                    FROM time_entries te
                    JOIN activities a ON te.activity_id = a.activity_id
                    WHERE te.end_time IS NOT NULL 
                    AND te.start_time BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') 
                                        AND LAST_DAY(CURDATE())
                    AND te.employee_id = $user_id";

                    // compute time entries that are only billable. to see billable activities there an 'activities' table columsn: activity_id, activity_name, isBillable (boolean)

        }elseif($role == 'A'){
            $sql = "SELECT entry_id, activity_name, start_time, end_time, TIMEDIFF(end_time, start_time) AS duration
                    FROM time_entries te
                    JOIN activities a ON te.activity_id = a.activity_id
                    WHERE te.end_time IS NOT NULL 
                    AND te.start_time BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') 
                                        AND LAST_DAY(CURDATE())";
        }elseif($role == 'M'){
            $sql = "SELECT 
                        te.entry_id, 
                        a.activity_name, 
                        te.start_time, 
                        te.end_time, 
                        TIMEDIFF(te.end_time, te.start_time) AS duration
                    FROM time_entries te
                    JOIN activities a ON te.activity_id = a.activity_id
                    JOIN employees e ON te.employee_id = e.user_id
                    JOIN teams t ON e.team_id = t.team_id
                    WHERE te.end_time IS NOT NULL 
                    AND t.user_id = $user_id
                    AND te.start_time BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') 
                                        AND LAST_DAY(CURDATE())";
       }
    
       
    
        $result = $this->conn->query($sql);
    
        if ($result) {
            return $result;
        } else {
            die("Error retrieving time entry data: " . $this->conn->error);
        }
    
        return $data;
    }

    public function get_live_activities() {
        $user_id = $_SESSION['user_id'];
        $role = $_SESSION['role'];

        if($role == 'A'){
            $sql = "SELECT 
                        e.user_id,
                        CONCAT(u.firstname, ' ', u.lastname) AS name, 
                        e.position,
                        t.team_name, 
                        d.department_name, 
                        a.activity_name,
                        TIMESTAMPDIFF(MINUTE, te.start_time, NOW()) AS duration
                    FROM employees e
                    LEFT JOIN users u ON e.user_id = u.user_id 
                    LEFT JOIN teams t ON e.team_id = t.team_id 
                    LEFT JOIN departments d ON t.department_id = d.department_id 
                    LEFT JOIN time_entries te ON e.user_id = te.employee_id 
                    LEFT JOIN activities a ON te.activity_id = a.activity_id 
                    WHERE u.online = 1 
                    AND te.start_time = (
                        SELECT MAX(start_time) 
                        FROM time_entries 
                        WHERE employee_id = e.user_id
                    )";
        }elseif($role == 'M'){
            $sql = "SELECT 
                        e.user_id,
                        CONCAT(u.firstname, ' ', u.lastname) AS name, 
                        e.position,
                        t.team_name, 
                        d.department_name, 
                        a.activity_name,
                        TIMESTAMPDIFF(MINUTE, te.start_time, NOW()) AS duration
                    FROM employees e
                    LEFT JOIN users u ON e.user_id = u.user_id 
                    LEFT JOIN teams t ON e.team_id = t.team_id 
                    LEFT JOIN departments d ON t.department_id = d.department_id 
                    LEFT JOIN time_entries te ON e.user_id = te.employee_id 
                    LEFT JOIN activities a ON te.activity_id = a.activity_id 
                    WHERE t.user_id = $user_id
                    AND u.online = 1 
                    AND te.start_time = (
                        SELECT MAX(start_time) 
                        FROM time_entries 
                        WHERE employee_id = e.user_id
                    )";
        }
    
        if ($result = $this->conn->query($sql)) {
            return $result;
        } else {
            die("Error retrieving live activities: " . $this->conn->error);
        }
    }
    
    public function get_employee_details($user_id){
  
        $sql = "SELECT 
                    u.firstname, 
                    u.lastname, 
                    u.email, 
                    u.username, 
                    u.contact_no, 
                    e.position,
                    e.team_id,
                    t.team_name AS team,
                    m.firstname AS manager_firstname,
                    m.lastname AS manager_lastname
                FROM users u
                INNER JOIN employees e ON u.user_id = e.user_id
                INNER JOIN teams t ON e.team_id = t.team_id
                LEFT JOIN users m ON t.user_id = m.user_id
                WHERE u.user_id = $user_id;";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // Assuming the employee data is found, fetch it
            $employee = $result->fetch_assoc();
            
            return $employee;
        } else {
            // Return an error if no employee is found
            echo json_encode(['error' => 'Employee not found']);
        }
    }
   
}

?>