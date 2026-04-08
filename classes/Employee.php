<?php

require_once "Database.php";

class Employee extends Database {

    public function shift($request) {
        session_start();
        $user_id = $_SESSION['user_id'];
        $shift_type = $request['btn_shift'];
        $current_time = $request['time']; // Get current server time
        $current_date = date("Y-m-d"); // Get current date
        
        
        // Update the user's online status
        $sql = "UPDATE users SET `online` = $shift_type WHERE `user_id` = $user_id";
        $result = $this->conn->query($sql);
    
        if (!$result) {
            die("Error updating status: " . $this->conn->error);
        }
    
        if ($shift_type == 1) { // Start of shift
            // Insert a new shift record
            $sql = "INSERT INTO shifts (`employee_id`, `shift_date`, `shift_start`) 
                    VALUES ($user_id, '$current_date', '$current_time')";
            $insert_result = $this->conn->query($sql);
    
            if (!$insert_result) {
                die("Error starting shift: " . $this->conn->error);
            }
        } else { // End of shift
             // Step 1: Get the latest shift without an end
            $sql = "SELECT shift_start 
                    FROM shifts 
                    WHERE employee_id = $user_id 
                    AND shift_date = '$current_date' 
                    AND shift_end IS NULL 
                    ORDER BY shift_start DESC 
                    LIMIT 1";
            
            $result = $this->conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $shift = $result->fetch_assoc();
                $latest_shift_start = $shift['shift_start'];

                // Step 2: Update that shift's end time
                $sqlUpdateShift = "UPDATE shifts 
                                SET shift_end = '$current_time' 
                                WHERE employee_id = $user_id 
                                    AND shift_date = '$current_date' 
                                    AND shift_start = '$latest_shift_start'";
                $updateShift = $this->conn->query($sqlUpdateShift);

                if (!$updateShift) {
                    die("Error ending shift: " . $this->conn->error);
                }

                // Step 3: Update the latest time entry with no end_time (in this shift)
                $sqlUpdateEntry = "UPDATE time_entries 
                                SET end_time = '$current_time' 
                                WHERE employee_id = $user_id 
                                    AND date = '$current_date' 
                                    AND start_time >= '$latest_shift_start' 
                                    AND end_time IS NULL 
                                ORDER BY start_time DESC 
                                LIMIT 1";

                $updateEntry = $this->conn->query($sqlUpdateEntry);

                if (!$updateEntry) {
                    die("Error updating last activity log: " . $this->conn->error);
                }
            } else {
                echo "No active shift found to end.";
            }
        }
    
        // Redirect back to the activity page
        header("location: ../../views/employee/activity.php");
        exit();
    }
    

    public function update_activity($request) {
        session_start();
        $user_id = $_SESSION['user_id'];
        $activity_id = $request['activity'];
        $current_time = $request['time']; // Current time from form
        $current_date = date("Y-m-d"); // Current date
    
        // Get the last recorded activity that is still open
        $check_sql = "SELECT entry_id, start_time, date FROM time_entries 
                      WHERE employee_id = $user_id AND end_time IS NULL 
                      ORDER BY date DESC, start_time DESC LIMIT 1";
        $check_result = $this->conn->query($check_sql);
    
        if ($check_result->num_rows > 0) {
            // Found an ongoing activity, close it
            $row = $check_result->fetch_assoc();
            $entry_id = $row['entry_id'];
            $start_time = $row['start_time'];
            $start_date = $row['date'];
    
            // Handle shifts that cross midnight correctly
            $start_datetime = strtotime("$start_date $start_time");
            $current_datetime = strtotime("$current_date $current_time");
    
            if ($current_datetime < $start_datetime) {
                // If the current time is "before" the start time, it means we've crossed midnight
                $current_datetime = strtotime("+1 day", $current_datetime);
            }
    
            $duration_seconds = $current_datetime - $start_datetime;
            $duration = gmdate("H:i:s", max(0, $duration_seconds)); // Ensure no negative values
    
            // Update the last activity with end_time and duration
            $update_sql = "UPDATE time_entries 
                           SET end_time = '$current_time', duration = '$duration' 
                           WHERE entry_id = $entry_id";
            $this->conn->query($update_sql);
        }

        $sql = "
            SELECT * 
            FROM shifts 
            WHERE employee_id = $user_id 
            ORDER BY shift_date DESC, shift_start DESC 
            LIMIT 1
        ";

        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $shift_id = $row['shift_id'];
        }
        // Insert the new activity
        $insert_sql = "INSERT INTO time_entries (`employee_id`, `activity_id`, `date`, `start_time`, `shift_id`) 
                       VALUES ($user_id, $activity_id, '$current_date', '$current_time', $shift_id)";
        $this->conn->query($insert_sql);
    
        // Redirect after success
        // header("location: ../../views/employee/activity.php");
        if ($this->conn->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    
     

    public function get_activities() {
        $user_id = $_SESSION['user_id'];
        $current_date = date("Y-m-d");

        // Get the latest shift for today
        $sql = "SELECT shift_start, shift_end, shift_date FROM shifts 
                WHERE employee_id = $user_id 
                AND shift_date = '$current_date' 
                ORDER BY shift_start DESC 
                LIMIT 1";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $shift = $result->fetch_assoc();
            $shift_start = $shift['shift_start'];
            $shift_end = $shift['shift_end']; // Might be NULL
        } else {
            return [];
        }

        // Define fallback end_time if not set
        $fallback_end = $shift_end ? "'$shift_end'" : "NULL";
        $sql = "SELECT te.entry_id, te.employee_id, te.activity_id, a.activity_name, a.isBillable, 
                    te.date, te.start_time, te.end_time,
                    CASE 
                    WHEN te.end_time IS NOT NULL THEN TIME_FORMAT(TIMEDIFF(te.end_time, te.start_time), '%H:%i:%s')
                    WHEN '$shift_end' IS NOT NULL THEN TIME_FORMAT(TIMEDIFF('$shift_end', te.start_time), '%H:%i:%s')
                    ELSE NULL
                END AS duration,
                    te.remarks 
                FROM time_entries te
                INNER JOIN activities a ON te.activity_id = a.activity_id
                WHERE te.employee_id = $user_id 
                AND te.date = (
                    SELECT MAX(date)
                    FROM time_entries
                    WHERE employee_id = $user_id
                )
                ORDER BY te.start_time DESC;";

        return $this->conn->query($sql);
        

    }

    

    public function get_specific_activity($entry_id){
        $sql = "SELECT te.*, a.activity_name, a.activity_id
        FROM time_entries te
        LEFT JOIN activities a ON te.activity_id = a.activity_id
        WHERE te.entry_id = $entry_id";

        if($result = $this->conn->query($sql)){
            return $result;
        }else{
            die("Error retrieving time entry data. ".  $this->conn->error);
        }
    }
   
    public function get_current_activity() {
        $user_id = $_SESSION['user_id'];
        $sql = "
            SELECT shift_id
            FROM shifts
            WHERE employee_id = $user_id
            AND shift_end IS NULL
            ORDER BY shift_date DESC, shift_start DESC
            LIMIT 1
        ";

        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        $shift_id = $row['shift_id'] ?? null; // null if no shift

        // If no shift, return empty
        if (!$shift_id) {
            return null; // or an empty array depending on your handling
        }

        // Only query time_entries if shift exists
        $sql = "SELECT te.*, a.activity_name 
                FROM time_entries te 
                LEFT JOIN activities a ON te.activity_id = a.activity_id 
                WHERE te.employee_id = $user_id
                AND te.shift_id = $shift_id
                ORDER BY te.start_time DESC 
                LIMIT 1";

        if ($result = $this->conn->query($sql)) {
            return $result;
        } else {
            die("Error retrieving time entry data: " . $this->conn->error);
        }
    }

    public function get_next_activity($user_id, $entry_id){
        // Get the current activity using your existing function
        $currentActivityResult = $this->get_specific_activity($entry_id);

        if($currentActivityResult->num_rows == 0){
            return null; // No current activity found
        }

        $currentActivity = $currentActivityResult->fetch_assoc();
        $currentStartTime = $currentActivity['start_time'];

        // Get the next activity for the same user
        $nextSql = "SELECT te.*, a.activity_name
                    FROM time_entries te
                    LEFT JOIN activities a ON te.activity_id = a.activity_id
                    WHERE te.user_id = $user_id AND te.start_time > '$currentStartTime'
                    ORDER BY te.start_time ASC
                    LIMIT 1";

        $nextResult = $this->conn->query($nextSql);

        if($nextResult && $nextResult->num_rows > 0){
            return $nextResult->fetch_assoc();
        }

        return null; // No next activity
    }

    



    public function get_ShiftActive() {
        $employee_id = $_SESSION['user_id'];

        $sql = "
            SELECT shift_end 
            FROM shifts 
            WHERE employee_id = $employee_id 
            ORDER BY shift_date DESC, shift_start DESC 
            LIMIT 1
        ";

        $result = $this->conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $shift = $result->fetch_assoc();
            return empty($shift['shift_end']); // true if still in shift
        }

        return false; // No shift found
    }



    public function add_activity_remark($activity_id, $remarks) {
        session_start();
        $user_id = $_SESSION['user_id'];
        $remarks = $this->conn->real_escape_string($remarks);
    
        $sql = "UPDATE time_entries 
                SET `remarks` = '$remarks' 
                WHERE `entry_id` = $activity_id AND `employee_id` = $user_id";
    
        $result = $this->conn->query($sql);
    
        if (!$result) {
            die("Error updating remark: " . $this->conn->error);
        } else {
            return true;
        }
    }


    public function get_manager(){
        session_start();
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT 
                    t.team_id,
                    t.team_name,
                    CONCAT(u.firstname, ' ', u.lastname) AS name,
                    t.user_id as manager_id
                FROM 
                    teams t
                LEFT JOIN users u ON t.user_id = u.user_id
                LEFT JOIN employees e ON t.team_id = e.team_id
                WHERE e.user_id = $user_id
                LIMIT 1;"; // optional if you only need one manager

        $result = $this->conn->query($sql);

        if (!$result) {
            die("Error getting manager details: " . $this->conn->error);
        } else {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row; // return the manager's name
            } else {
                return null; // no manager found
            }
        }        
    }
    public function validate_shift_bounds_for_entry(
        int $entry_id,
        ?string $new_start_time,
        ?string $new_end_time
    ) {

        // 1️⃣ Load entry context
        $sql = "
            SELECT entry_id, employee_id, date, start_time, shift_id
            FROM time_entries
            WHERE entry_id = $entry_id
            LIMIT 1
        ";

        $res = $this->conn->query($sql);
        if (!$res || $res->num_rows === 0) {
            return [false, "Entry not found"];
        }


        $entry = $res->fetch_assoc();

       

        $employee_id = $entry['employee_id'];
        $shift_id = $entry['shift_id'];
        $date = $entry['date'];

        // 2️⃣ Load shift bounds
        $shift_sql = "
            SELECT shift_start, shift_end
            FROM shifts
            WHERE employee_id = $employee_id
            AND shift_id = '$shift_id'
            LIMIT 1
        ";

        $shift_res = $this->conn->query($shift_sql);
        if (!$shift_res || $shift_res->num_rows === 0) {
            return [false, "Shift not found"];
        }

        $shift = $shift_res->fetch_assoc();


        $shift_start_dt = strtotime("$date {$shift['shift_start']}");
        $shift_end_dt   = strtotime("$date {$shift['shift_end']}");

        // 3️⃣ Detect FIRST entry of the day
        $first_sql = "
            SELECT entry_id
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
            SELECT entry_id
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

            if ($new_end_dt > $shift_end_dt) {
                return [false, "End time cannot exceed shift end"];
            }
        }

        return [true, null];
    }

    public function create_correction_request($request)
    {
        $user_id      = $request['user_id'];
        $end_time     = $request['end_time'] ?? null;
        $request_date = $request['requested_date'];
        $remarks      = $request['remarks'];
        $entry_id     = $request['entry_id'];
        $manager_id   = $request['manager_id'];
        $activity_id  = $request['activity_id'];
        $start_time   = $request['start_time'] ?? null;

        // normalize empty string → null
        if ($start_time === '') {
            $start_time = null;
        }

        // 🔹 BACKEND VALIDATION
        $validation = $this->validate_shift_bounds_for_entry(
            $entry_id,
            $start_time,
            $end_time
        ); 
        
        // return json_encode($validation[0]);

        if (!$validation[0]) {
            return json_encode([
                "status" => "error",
                "message" => $validation[1]
            ]);
        }


        // 🔹 Get current entry times
        $sql = "SELECT start_time, end_time FROM time_entries WHERE entry_id = $entry_id";
        $result = $this->conn->query($sql);
        $previous_data = $result->fetch_assoc();

        $initial_start_time = $previous_data['start_time'];
        $initial_end_time   = $previous_data['end_time'];

        // 🔹 Build INSERT dynamically
        $columns = [
            "employee_id",
            "request_date",
            "end_time",
            "remarks",
            "entry_id",
            "manager_id",
            "activity_id",
            "initial_end_time"
        ];

        $values = [
            $user_id,
            "'$request_date'",
            $end_time ? "'$end_time'" : "NULL",
            "'$remarks'",
            $entry_id,
            $manager_id,
            $activity_id,
            "'$initial_end_time'"
        ];

        // 🔹 Add start fields ONLY if provided
        if ($start_time !== null) {
            $columns[] = "start_time";
            $columns[] = "initial_start_time";

            $values[] = "'$start_time'";
            $values[] = "'$initial_start_time'";
        }

        $sql = "INSERT INTO time_adjustment_requests (" .
            implode(", ", $columns) .
            ") VALUES (" .
            implode(", ", $values) .
            ")";

        $insert_result = $this->conn->query($sql);

        if (!$insert_result) {
            die("Error creating request: " . $this->conn->error);
        }

        return json_encode([
            "status" => "success",
            "message" => "Correction request created successfully"
        ]);
    }

    // public function create_correction_request($request){
    //     $user_id = $request['user_id'];
    //     $end_time = $request['end_time'];
    //     $request_date = $request['requested_date'];
    //     $remarks = $request['remarks'];
    //     $entry_id = $request['entry_id'];
    //     $manager_id = $request['manager_id'];
    //     $activity_id = $request['activity_id'];
    //     $start_time = $request['start-time-input'] ?? null;
    

    //     $sql = "SELECT end_time FROM time_entries WHERE entry_id = $entry_id";

    //     $result= $this->conn->query($sql);
    //     $previous_data = $result->fetch_assoc();
    //     $initial_end_time = $previous_data['end_time'];

    //     // Insert a new shift record
    //     $sql = "INSERT INTO time_adjustment_requests (`employee_id`, `request_date`, `end_time`, `remarks`, `entry_id`, `manager_id`,`activity_id`, `initial_end_time`) 
    //             VALUES ($user_id, '$request_date', '$end_time', '$remarks', $entry_id, $manager_id, $activity_id, '$initial_end_time')";
    //     $insert_result = $this->conn->query($sql);

    //     if (!$insert_result) {
    //         die("Error creating request: " . $sql);
    //     }else{
    //         return true;
    //     }
    // }


    
    
    
    
}