<?php

require_once "Database.php";

class Admin extends Database {
    /**
     * CHECKLIST: 
     *  DONE: 
     *      - Add/Delete Activities
     *      - Edit Activity (name/isBillable)
     *      - Create Department
     *      - Create Employee
     *      - Create Team 
     *      - Create Manager
     *      - Dashboard Visualizations
     *      - Live Activity table
     *      
     *
     *  TODO: 
     *      
     *      - Dashboard Filters
     *      - Dashboard Date range filter
     *      - Dashboard export data (CSV/Excel)
     *      - Team management : Filter team table
     *      - Team Management : Delete Department
     *      - Dashboard Data Fix
     *      - Edit Department
     *      - Edit Manager Details
     *      - Edit Employee Details
     *      - Edit Team Details
     *      
     * 
     * TODO: fix chart if activity is less than an hour (chart is empty if data is all less than an hour)
     */

    
    public function create_employee($request){
        // print_r($request);
        $username = $request['username'];
        $firstname = $request['firstname'];
        $lastname = $request['lastname'];
        $email = $request['email'];
        $contact_no = $request['contact'];
        $team_id = !empty($request['team']) ? (int) $request['team'] : "NULL";
        $position = $request['position'];
        $password = password_hash($request['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (`username`, `firstname`, `lastname`, `email`, `contact_no`, `password`, `role`, `status`, `admin_level`) VALUES ('$username', '$firstname', '$lastname', '$email', '$contact_no', '$password', 'Employee', 'Active', 0)";

        if($this->conn->query($sql)){


            // INSERT INTO 2nd table
            $user_id = $this->conn->insert_id;

            $sql = "INSERT INTO employees (`user_id`, `team_id`, `position`) VALUES ($user_id, $team_id, '$position')";

            if($this->conn->query($sql)){
                // Get the previous page URL
                $prevPage = $_SERVER['HTTP_REFERER'];

                // // Redirect to the previous page
                header("Location: $prevPage");
                exit;
            }else{
                die("Error Registering Employee: " . $this->conn->error);

            }
        }else{
            die("Error Registering Employee: " . $this->conn->error);
        }
    }

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
            if ($team_id !== null && $department_id !== null) {
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
            header('location: ../views/admin/team-management.php');
        } else{
            die("Error retrieving all departments: " . $conn->error);
        }
    }

    public function create_team($request) {
        $team_name = $request['team_name'];
        $status = $request['status'];
        $department_id = !empty($request['department']) ? $request['department'] : "NULL";
        $manager_id = !empty($request['manager']) ? $request['manager'] : "NULL";

        $employees = array_filter($request['employees']); // This is already an array
        
        // Insert new team and get the inserted team's ID
        $sql = "INSERT INTO teams (`user_id`, `department_id`, `team_name`, `status`) 
        VALUES (" . ($manager_id === "NULL" ? "NULL" : $manager_id) . ", 
                " . ($department_id === "NULL" ? "NULL" : $department_id) . ", 
                '$team_name', 
                '$status')";
    
        if ($this->conn->query($sql)) {
            $team_id = $this->conn->insert_id; // Get last inserted ID
            
            // Now, update employees to assign them to this team
           
            if(!empty($employees)){
                foreach ($employees as $employee_id) {
                    $update_sql = "UPDATE employees SET `team_id` = $team_id WHERE `user_id` = $employee_id";
                    echo "$update_sql";
                    if($this->conn->query($update_sql)){
                        echo "added";
                    }else{
                        die("erorr:". $this->conn->error );
                    }
                }
            }
    
            // Redirect after successful creation
            header("location: ../../views/admin/team-management.php");
            exit;
        } else {
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

    public function get_all_employees(){
        $sql = "SELECT 
                    e.user_id,
                    e.position,
                    CONCAT(u.firstname, ' ', u.lastname) AS name, 
                    u.status
                FROM 
                    employees e
                LEFT JOIN users u ON e.user_id = u.user_id";

        if($result = $this->conn->query($sql)){
            return $result;
        }else{
            die("Error retrieving list of employees: " . $this->conn->error);
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

    public function delete_activity($activity_id){
        $sql = "DELETE from activities WHERE `activity_id` = $activity_id";

        if($this->conn->query($sql)){
            header("location: ../../views/shared/dashboard.php");
            exit;
        } else{
            die("Error deleting team: " . $this->conn->error);
        }
    }

    public function delete_employee($employee_id) {
        $employee_id = intval($employee_id); // sanitize input

        // Step 1: Delete from time_entries using JOIN on employees
        // $sql_time_entries = "
        //     DELETE FROM time_entries 
        //     WHERE employee_id = $employee_id
        // ";
        // if (!$this->conn->query($sql_time_entries)) {
        //     die("Error deleting time entries: " . $this->conn->error);
        // }

        // Step 2: Delete from employees using user_id
        $sql_employees = "
            DELETE FROM employees WHERE user_id = $employee_id
        ";
        if (!$this->conn->query($sql_employees)) {
            die("Error deleting employee record: " . $this->conn->error);
        }

        // Step 3: Delete from users using user_id
        $sql_users = "
            DELETE FROM users WHERE user_id = $employee_id
        ";
        if ($this->conn->query($sql_users)) {
            header("location: ../../views/admin/view-employee-list.php");
            exit;
        } else {
            die("Error deleting user: " . $this->conn->error);
        }
    }

    public function delete_manager($manager_id) {
        $manager_id = intval($manager_id); // Sanitize input

        // Step 1: Set user_id to NULL in teams where this manager is assigned
        $sql_update_teams = "
            UPDATE teams SET user_id = NULL WHERE user_id = $manager_id
        ";
        if (!$this->conn->query($sql_update_teams)) {
            die("Error updating teams: " . $this->conn->error);
        }

        // Step 2: Delete the manager from users
        $sql_delete_user = "
            DELETE FROM users WHERE user_id = $manager_id
        ";
        if ($this->conn->query($sql_delete_user)) {
            header("Location: ../../views/admin/view-manager-list.php");
            exit;
        } else {
            die("Error deleting user: " . $this->conn->error);
        }
    }



    public function delete_department($department_id){
        $sql = "DELETE from departments WHERE `department_id` = $department_id";

        if($this->conn->query($sql)){
            header("location: ../../views/admin/team-management.php");
            exit;
        } else{
            die("Error deleting team: " . $this->conn->error);
        }
    }

    public function update_activity($activity_id, $activity_name, $isBillable)
    {
        $activity_id = intval($activity_id);
        $activity_name = $this->conn->real_escape_string(trim($activity_name));
        $isBillable = intval($isBillable);

        $sql = "UPDATE activities 
                SET `activity_name` = '$activity_name', `isBillable` = $isBillable 
                WHERE `activity_id` = $activity_id";

        $result = $this->conn->query($sql);
        

        return $result ? true : false;
    }

    public function get_specific_team($team_id){
        $sql = "SELECT 
                t.team_id,
                t.team_name,
                u.user_id,
                d.department_id,
                concat(u.firstname, u.lastname) AS name,  -- Assuming `user_name` is the column for user names
                d.department_name AS department_name,  -- Assuming `department_name` is the column for department names
                t.status
            FROM 
                teams t
            LEFT JOIN users u ON t.user_id = u.user_id
            LEFT JOIN departments d ON t.department_id = d.department_id
            WHERE t.team_id = $team_id;";

        if($result = $this->conn->query($sql)){
            return $result->fetch_assoc();
        }else{
            die("Error retrieving teams table: " . $this->conn->error);
        }

    }
    
    public function get_specific_team_employees($team_id) {
        $sql = "SELECT 
                    e.user_id,
                    e.position,
                    CONCAT(u.firstname, ' ', u.lastname) AS name, 
                    u.status
                FROM 
                    employees e
                LEFT JOIN users u ON e.user_id = u.user_id
                WHERE e.team_id = ?";

        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $team_id); // "i" means integer
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        } else {
            die("Error preparing statement: " . $this->conn->error);
        }
    }

     public function edit_team($request) {
        $team_id = $request['team_id'];  // Make sure this is passed in the request
        $team_name = $request['team_name'];
        $status = $request['status'];
        $department_id = $request['department'];
        $manager_id = $request['manager'];
        $employees = $request['employees']; // Clean array of employees
        $employees = explode(',', $employees[0]);
       

        // 1. Update the team info (name, manager, department, status)
        $sql = "UPDATE teams 
                SET `user_id` = $manager_id,
                    `department_id` = $department_id,
                    `team_name` = '$team_name',
                    `status` = '$status'
                WHERE team_id = $team_id";

        if ($this->conn->query($sql)) {

            // 2. Unassign all employees from this team first (optional but recommended)
            $reset_sql = "UPDATE employees SET team_id = NULL WHERE team_id = $team_id";
            $this->conn->query($reset_sql);

            // 3. Reassign selected employees to the updated team
            if (!empty($employees[0])) {
                foreach ($employees as $employee_id) {
                    $update_sql = "UPDATE employees SET team_id = $team_id WHERE user_id = $employee_id";
                    if (!$this->conn->query($update_sql)) {
                        die("Error assigning employee: " . $this->conn->error);
                    }
                }
            }

            // Redirect after successful update
            header("location: ../../views/admin/team-management.php");
            exit;

        } else {
            die("Error updating team: " . $this->conn->error);
        }
    }

    public function get_manager_list(){
        $sql = "SELECT 
                    u.user_id,
                    u.firstname, 
                    u.lastname, 
                    u.email, 
                    u.username, 
                    u.contact_no,
                    t.team_name AS team,
                    t.department_id,
                    d.department_name AS department
                FROM users u
                LEFT JOIN teams t ON u.user_id = t.user_id
                LEFT JOIN departments d ON t.department_id = d.department_id
                WHERE u.role = 'M';
                ";

        if($result = $this->conn->query($sql)){
            return $result;
        } else{
            die("Error retrieving all departments: " . $conn->error);
        }
    }

    public function get_employee_list(){
        $sql = "SELECT 
            u.user_id,
            u.firstname, 
            u.lastname, 
            u.email, 
            u.username, 
            u.contact_no, 
            u.role,
            e.position,
            e.team_id,
            t.team_name AS team,
            m.firstname AS manager_firstname,
            m.lastname AS manager_lastname
        FROM users u
        INNER JOIN employees e ON u.user_id = e.user_id
        LEFT JOIN teams t ON e.team_id = t.team_id
        LEFT JOIN users m ON t.user_id = m.user_id
        WHERE u.role = 'E';";

        if($result = $this->conn->query($sql)){
            return $result;
        } else{
            die("Error retrieving all employee list: " . $conn->error);
        }
    }
    
            

}

?>