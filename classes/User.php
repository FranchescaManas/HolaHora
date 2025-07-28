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
        $sql = "UPDATE `users` SET `online` = 0 WHERE `user_id` = $user_id";

        if($this->conn->query($sql)){

            session_unset();
            session_abort();
            session_destroy();
            
            header('Location: ../..');
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
        
        // Base duration calculation that accounts for cross-midnight
        $duration_sql = "ROUND(SUM(
            CASE 
                WHEN te.end_time > te.start_time 
                    THEN TIMESTAMPDIFF(SECOND, te.start_time, te.end_time)
                ELSE TIMESTAMPDIFF(SECOND, te.start_time, DATE_ADD(te.end_time, INTERVAL 1 DAY))
            END
        ) / 3600, 2) AS total_hours";

        if ($role == 'E') {
            $sql = "SELECT 
                        a.activity_name,
                        $duration_sql
                    FROM time_entries te
                    JOIN activities a ON te.activity_id = a.activity_id
                    WHERE te.end_time IS NOT NULL 
                    AND te.start_time BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE())
                    AND te.employee_id = $user_id
                    GROUP BY a.activity_id, a.activity_name
                    ORDER BY a.activity_name";
        } elseif ($role == 'A') {
            $sql = "SELECT 
                        a.activity_name,
                        $duration_sql
                    FROM time_entries te
                    JOIN activities a ON te.activity_id = a.activity_id
                    WHERE te.end_time IS NOT NULL 
                    AND te.start_time BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE())
                    GROUP BY a.activity_id, a.activity_name
                    ORDER BY a.activity_name";
        } elseif ($role == 'M') {
            $sql = "SELECT 
                        a.activity_name,
                        $duration_sql
                    FROM time_entries te
                    JOIN activities a ON te.activity_id = a.activity_id
                    JOIN employees e ON te.employee_id = e.user_id
                    JOIN teams t ON e.team_id = t.team_id
                    WHERE te.end_time IS NOT NULL 
                    AND t.user_id = $user_id
                    AND te.start_time BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE())
                    GROUP BY a.activity_id, a.activity_name
                    ORDER BY a.activity_name";
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

        // Cross-midnight duration calculation
        $duration_sql = "CASE 
                            WHEN te.end_time > te.start_time 
                                THEN SEC_TO_TIME(TIMESTAMPDIFF(SECOND, te.start_time, te.end_time))
                            ELSE SEC_TO_TIME(TIMESTAMPDIFF(SECOND, te.start_time, DATE_ADD(te.end_time, INTERVAL 1 DAY)))
                        END AS duration";

        if ($role == 'E') {
            $sql = "SELECT 
                        te.entry_id, 
                        a.activity_name, 
                        te.start_time, 
                        te.end_time,
                        te.date, 
                        $duration_sql
                    FROM time_entries te
                    JOIN activities a ON te.activity_id = a.activity_id
                    WHERE te.end_time IS NOT NULL 
                    AND te.start_time BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE())
                    AND te.employee_id = $user_id
                    AND a.isBillable = 1";
        } elseif ($role == 'A') {
            $sql = "SELECT 
                        te.entry_id, 
                        a.activity_name, 
                        te.start_time, 
                        te.end_time,
                        te.date, 
                        $duration_sql
                    FROM time_entries te
                    JOIN activities a ON te.activity_id = a.activity_id
                    WHERE te.end_time IS NOT NULL 
                    AND te.start_time BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE())
                    AND a.isBillable = 1";
        } elseif ($role == 'M') {
            $sql = "SELECT 
                        te.entry_id, 
                        a.activity_name, 
                        te.start_time, 
                        te.end_time,
                        te.date, 
                        $duration_sql
                    FROM time_entries te
                    JOIN activities a ON te.activity_id = a.activity_id
                    JOIN employees e ON te.employee_id = e.user_id
                    JOIN teams t ON e.team_id = t.team_id
                    WHERE te.end_time IS NOT NULL 
                    AND t.user_id = $user_id
                    AND te.start_time BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE())
                    AND a.isBillable = 1";
        }

        $result = $this->conn->query($sql);

        if ($result) {
            return $result; // or fetch results into array if preferred
        } else {
            die("Error retrieving time entry data: " . $this->conn->error);
        }
    }


    public function get_live_activities() {
        $user_id = $_SESSION['user_id'];
        $role = $_SESSION['role'];

        if ($role == 'A') {
            $sql = "SELECT 
                        e.user_id,
                        CONCAT(u.firstname, ' ', u.lastname) AS name, 
                        e.position,
                        t.team_name, 
                        d.department_name, 
                        a.activity_name,
                        GREATEST(TIMESTAMPDIFF(MINUTE, te.start_time, NOW()), 0) AS duration
                    FROM employees e
                    LEFT JOIN users u ON e.user_id = u.user_id 
                    LEFT JOIN teams t ON e.team_id = t.team_id 
                    LEFT JOIN departments d ON t.department_id = d.department_id 
                    LEFT JOIN time_entries te ON e.user_id = te.employee_id 
                    LEFT JOIN activities a ON te.activity_id = a.activity_id 
                    WHERE u.online = 1 
                    AND te.start_time IS NOT NULL
                    AND te.end_time IS NULL";
        } elseif ($role == 'M') {
            $sql = "SELECT 
                        e.user_id,
                        CONCAT(u.firstname, ' ', u.lastname) AS name, 
                        e.position,
                        t.team_name, 
                        d.department_name, 
                        a.activity_name,
                        GREATEST(TIMESTAMPDIFF(MINUTE, te.start_time, NOW()), 0) AS duration
                    FROM employees e
                    LEFT JOIN users u ON e.user_id = u.user_id 
                    LEFT JOIN teams t ON e.team_id = t.team_id 
                    LEFT JOIN departments d ON t.department_id = d.department_id 
                    LEFT JOIN time_entries te ON e.user_id = te.employee_id 
                    LEFT JOIN activities a ON te.activity_id = a.activity_id 
                    WHERE t.user_id = $user_id
                    AND u.online = 1 
                    AND te.start_time IS NOT NULL
                    AND te.end_time IS NULL";
        }

        if ($result = $this->conn->query($sql)) {
            return $result;
        } else {
            die("Error retrieving live activities: " . $this->conn->error);
        }
    }


    
    public function get_employee_details($user_id){
  
        $sql = "
                SELECT 
                    u.user_id,
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
                LEFT JOIN teams t ON e.team_id = t.team_id
                LEFT JOIN users m ON t.user_id = m.user_id
                WHERE u.user_id = $user_id
            ";
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


    public function edit_employee_detail($request) {
        session_start();
        $user_id = (int) $request['user_id'];
        $role = $_SESSION['role'];

        // Prepare users table fields
        $user_fields = [];
        if (!empty($request['firstname'])) $user_fields[] = "firstname = '" . $this->conn->real_escape_string($request['firstname']) . "'";
        if (!empty($request['lastname'])) $user_fields[] = "lastname = '" . $this->conn->real_escape_string($request['lastname']) . "'";
        if (!empty($request['email'])) $user_fields[] = "email = '" . $this->conn->real_escape_string($request['email']) . "'";
        if (!empty($request['contact_no'])) $user_fields[] = "contact_no = '" . $this->conn->real_escape_string($request['contact_no']) . "'";
        if (!empty($request['username'])) $user_fields[] = "username = '" . $this->conn->real_escape_string($request['username']) . "'";

        if (!empty($user_fields)) {
            $sql_user = "UPDATE users SET " . implode(', ', $user_fields) . " WHERE user_id = $user_id";
            if (!$this->conn->query($sql_user)) {
                return "Error updating users table: " . $this->conn->error;
            }
        }

        // Prepare employees table fields
        $emp_fields = [];
        if (!empty($request['position'])) $emp_fields[] = "position = '" . $this->conn->real_escape_string($request['position']) . "'";
        if (!empty($request['team_id'])) $emp_fields[] = "team_id = '" . $this->conn->real_escape_string($request['team_id']) . "'";

        if (!empty($emp_fields)) {
            $sql_emp = "UPDATE employees SET " . implode(', ', $emp_fields) . " WHERE user_id = $user_id";
            if (!$this->conn->query($sql_emp)) {
                return "Error updating employees table: " . $this->conn->error;
            }
        }

        if ($role == "M"){
            header("location: ../../views/manager/team-management.php");
            exit();
        }
    }

   
}

?>