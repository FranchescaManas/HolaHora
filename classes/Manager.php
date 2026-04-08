<?php

require_once "Database.php";

class Manager extends Database {
    
    public function get_team_employees(){
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT
                    u.user_id,
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

    public function remove_employee($user_id){
        $sql = "UPDATE employees SET team_id = NULL WHERE user_id = $user_id";

        if($this->conn->query($sql)){
            header("location: ../../views/manager/team-management.php");
            exit;
        } else{
            die("Error removing employee from the team: " . $this->conn->error);
        }
    }


    public function get_correction_request($isHistory){
        $user_id = $_SESSION['user_id'];



        $sql = "SELECT 
                    CONCAT(u.firstname, ' ', u.lastname) AS employee_name,
                    t.team_name,
                    a.activity_name,
                    e.date AS activity_date, 
                    ta.request_date,
                    ta.entry_id,
                    ta.isApproved
                FROM time_adjustment_requests ta
                JOIN time_entries e ON ta.entry_id = e.entry_id
                JOIN activities a ON ta.activity_id = a.activity_id
                JOIN users u ON ta.employee_id = u.user_id
                JOIN employees emp ON ta.employee_id = emp.user_id
                JOIN teams t ON emp.team_id = t.team_id
                WHERE ta.manager_id = $user_id";
         // Only filter pending when NOT history
        if (!$isHistory) {
            // history → approved/rejected
            $sql .= " AND ta.isApproved IS NULL";
        } 
        $result = $this->conn->query($sql);
        
        if ($result) {
            return $result;
        }


    }
    public function get_employee_list(){
      $sql = "SELECT 
            u.user_id,
            u.firstname, 
            u.lastname, 
            concat(u.firstname, ' ', u.lastname) AS name,
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
        WHERE u.role = 'E'
        AND t.user_id = $user_id;";

        if($result = $this->conn->query($sql)){
            return $result;
        } else{
            die("Error retrieving all employee list: " . $conn->error);
        }
    }

    public function get_specific_activity($entry_id){
        $sql = "SELECT 
                    CONCAT(u.firstname, ' ', u.lastname) AS employee_name,
                    ta.initial_start_time as initial_start_time,
                    ta.start_time as requested_start_time,
                    te.duration,
                    te.end_time,
                    te.start_time,
                    a.activity_name,
                    e.date AS activity_date, 
                    ta.request_date,
                    ta.remarks,
                    ta.request_id,
                    ta.end_time as requested_end_time,
                    ta.initial_end_time as initial_end_time
                FROM time_adjustment_requests ta
                JOIN time_entries e ON ta.entry_id = e.entry_id
                JOIN activities a ON ta.activity_id = a.activity_id
                JOIN users u ON ta.employee_id = u.user_id
                JOIN employees emp ON ta.employee_id = emp.user_id
                JOIN time_entries te ON ta.entry_id = te.entry_id
                WHERE te.entry_id = $entry_id";

        if($result = $this->conn->query($sql)){
            return $result;
        }else{
            die("Error retrieving time entry data. ".  $this->conn->error);
        }
    }
    

    public function update_correction_entry($request_id, $start_time,$end_time, $isApproved)
    {
        try {
            // 1. Get current entry linked to the request
            $sql = "
                SELECT e.entry_id, e.employee_id, e.date, e.start_time, ta.end_time, ta.initial_end_time
                FROM time_entries e
                JOIN time_adjustment_requests ta 
                    ON ta.entry_id = e.entry_id
                WHERE ta.request_id = $request_id
                LIMIT 1
            ";
            $result = $this->conn->query($sql);
            if (!$result || $result->num_rows === 0) {
                throw new Exception("Entry not found");
            }

            $current = $result->fetch_assoc();
            if ($isApproved == 0) {
                // only mark request rejected
                if (!$this->conn->query("
                    UPDATE time_adjustment_requests
                    SET isApproved = 0
                    WHERE request_id = $request_id
                ")) {
                    throw new Exception("Failed to update adjustment request");
                }

                return true; // stop here
            }

            $entry_id    = $current['entry_id'];
            $employee_id = $current['employee_id'];
            $date        = $current['date'];
            // $start_time  = $current['start_time'];
            $initial_end_time  = $current['initial_end_time'];
            
        // Handle shifts that cross midnight correctly
        //  02 34 33 < 02 33 22 
            $start_datetime = strtotime("$date $start_time");
            $current_datetime = strtotime("$date $end_time");

            if ($current_datetime < $start_datetime) {
                // If the current time is "before" the start time, it means we've crossed midnight
                $current_datetime = strtotime("+1 day", $current_datetime);
            }

            $duration_seconds = $current_datetime - $start_datetime;
            $duration = gmdate("H:i:s", max(0, $duration_seconds)); // Ensure no negative values


            // 2. Update current entry end_time
            if (!$this->conn->query("
                UPDATE time_entries
                SET start_time = '$start_time', end_time = '$end_time', duration = '$duration'
                WHERE entry_id = $entry_id
            ")) {
                throw new Exception("Failed to update current entry");
            }

            // 3. Find next closest entry
            $next_sql = "
                SELECT entry_id, date, end_time, start_time
                FROM time_entries
                WHERE employee_id = $employee_id
                AND (
                        date > '$date'
                        OR (date = '$date' AND start_time > '$start_time')
                    )
                ORDER BY date ASC, start_time ASC
                LIMIT 1
            ";

            $next_result = $this->conn->query($next_sql);

            if ($next_result && $next_result->num_rows > 0) {
                $next = $next_result->fetch_assoc();
                $next_entry_id = $next['entry_id'];

                // 4. Update next entry start_time
                if (!$this->conn->query("
                    UPDATE time_entries
                    SET start_time = '$end_time'
                    WHERE entry_id = $next_entry_id
                ")) {
                    throw new Exception("Failed to update next entry start_time");
                }

                // 5. Recalculate next entry duration (if closed)
                if (!empty($next['end_time'])) {

                    $next_start_dt = strtotime($next['date'] . ' ' . $end_time);
                    $next_end_dt   = strtotime($next['date'] . ' ' . $next['end_time']);

                    // Handle midnight crossing
                    if ($next_end_dt < $next_start_dt) {
                        $next_end_dt = strtotime("+1 day", $next_end_dt);
                    }

                    $next_duration_seconds = max(0, $next_end_dt - $next_start_dt);
                    $next_duration = gmdate("H:i:s", $next_duration_seconds);
                
                
                

                    if (!$this->conn->query("
                        UPDATE time_entries
                        SET duration = '$next_duration'
                        WHERE entry_id = $next_entry_id
                    ")) {
                        throw new Exception("Failed to update next entry duration");
                    }
                }

            
                
            }

        //     // 6. Update adjustment request status
            if (!$this->conn->query("
                UPDATE time_adjustment_requests
                SET isApproved = $isApproved,
                    end_time = '$end_time'
                WHERE request_id = $request_id
            ")) {
                throw new Exception("Failed to update adjustment request");
            }


            return true;

        } catch (Exception $e) {
        
            return false;
        }
    }

    public function validate_shift_bounds_for_request(
    int $request_id,
    ?string $new_start_time,
    ?string $new_end_time
    ) {

        // 1️⃣ Load request + entry context
        $sql = "
            SELECT 
                e.entry_id,
                e.employee_id,
                e.date,
                e.start_time,
                e.end_time
            FROM time_entries e
            JOIN time_adjustment_requests ta
                ON ta.entry_id = e.entry_id
            WHERE ta.request_id = $request_id
            LIMIT 1
        ";

        $res = $this->conn->query($sql);
        if (!$res || $res->num_rows === 0) {
            return [false, "Entry not found"];
        }

        $row = $res->fetch_assoc();

        $entry_id    = $row['entry_id'];
        $employee_id = $row['employee_id'];
        $date        = $row['date'];

        // 2️⃣ Load shift
        $shift_sql = "
            SELECT shift_start, shift_end
            FROM shifts
            WHERE employee_id = $employee_id
            AND shift_date = '$date'
            LIMIT 1
        ";

        $shift_res = $this->conn->query($shift_sql);
        if (!$shift_res || $shift_res->num_rows === 0) {
            return [false, "Shift not found"];
        }

        $shift = $shift_res->fetch_assoc();
        $shift_start = $shift['shift_start'];
        $shift_end   = $shift['shift_end'];

        $shift_start_dt = strtotime("$date $shift_start");
        $shift_end_dt   = strtotime("$date $shift_end");

        // 3️⃣ Detect FIRST entry of the day
        $first_sql = "
            SELECT entry_id, start_time
            FROM time_entries
            WHERE employee_id = $employee_id
            AND date = '$date'
            ORDER BY start_time ASC
            LIMIT 1
        ";

        $first = $this->conn->query($first_sql)->fetch_assoc();
        $isFirst = ($first && $first['entry_id'] == $entry_id);

        // 4️⃣ Detect LAST entry of the day
        $last_sql = "
            SELECT entry_id, start_time
            FROM time_entries
            WHERE employee_id = $employee_id
            AND date = '$date'
            ORDER BY start_time DESC
            LIMIT 1
        ";

        $last = $this->conn->query($last_sql)->fetch_assoc();
        $isLast = ($last && $last['entry_id'] == $entry_id);

        // ================================
        // RULE 1: FIRST entry start bound
        // ================================
        if ($isFirst && $new_start_time !== null) {

            $new_start_dt = strtotime("$date $new_start_time");

            if ($new_start_dt < $shift_start_dt) {
                return [false, "Start time cannot be earlier than shift start"];
            }
        }

        // =================================
        // RULE 2: LAST entry end bound
        // =================================
        if ($isLast && $new_end_time !== null) {

            // shift must already have ended
            if (time() < $shift_end_dt) {
                return [false, "Cannot edit last entry before shift ends"];
            }

            $new_end_dt = strtotime("$date $new_end_time");

            // cannot exceed shift end
            if ($new_end_dt > $shift_end_dt) {
                return [false, "End time cannot exceed shift end"];
            }
        }

        return [true, null];
    }





    
}

?>