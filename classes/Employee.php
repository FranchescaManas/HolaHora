<?php

require_once "Database.php";

class Employee extends Database {

    public function shift($request) {
        // session_start();
        $user_id = $_SESSION['user_id'];
        $shift_type = $request['btn_shift'];
        $current_time = $request['time']; // Get current server time
        $current_date = date("Y-m-d"); // Get current date
        print_r($request);
    
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
            // Update the last shift record with the end time
            $sql = "UPDATE shifts 
                    SET `shift_end` = '$current_time' 
                    WHERE `employee_id` = $user_id 
                    AND `shift_date` = '$current_date' 
                    AND `shift_end` IS NULL 
                    ORDER BY `shift_start` DESC LIMIT 1";
            $update_result = $this->conn->query($sql);
    
            if (!$update_result) {
                die("Error ending shift: " . $this->conn->error);
            }
        }
    
        // Redirect back to the activity page
        header("location: ../../views/employee/activity.php");
        exit();
    }
    

    public function update_activity($request) {
        // session_start();
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
    
        // Insert the new activity
        $insert_sql = "INSERT INTO time_entries (`employee_id`, `activity_id`, `date`, `start_time`) 
                       VALUES ($user_id, $activity_id, '$current_date', '$current_time')";
        $this->conn->query($insert_sql);
    
        // Redirect after success
        header("location: ../../views/employee/activity.php");
    }
    
     

    public function get_activities() {
        // TODO: error handling (past midnight and date reference should be shift_start)
       
        $user_id = $_SESSION['user_id'];
    
        // Get the latest shift start time for today
        $current_date = date("Y-m-d");
        $sql = "SELECT shift_start FROM shifts 
                WHERE employee_id = $user_id 
                AND shift_date = '$current_date' 
                ORDER BY shift_start DESC 
                LIMIT 1";
    
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $shift = $result->fetch_assoc();
            $shift_start = $shift['shift_start'];
        } else {
            // No shift found, return empty result
            return [];
        }
    
        // Retrieve activities after the shift started, computing duration using TIMEDIFF
        $sql = "SELECT te.entry_id, te.employee_id, te.activity_id, a.activity_name, a.isBillable, 
                       te.date, te.start_time, te.end_time, 
                       CASE 
                           WHEN te.end_time IS NOT NULL THEN TIMEDIFF(te.end_time, te.start_time)
                           ELSE NULL 
                       END AS duration, 
                       te.remarks 
                FROM time_entries te
                INNER JOIN activities a ON te.activity_id = a.activity_id
                WHERE te.employee_id = $user_id 
                AND te.date = '$current_date' 
                AND te.start_time >= '$shift_start' 
                ORDER BY te.start_time ASC";
    
        return $result = $this->conn->query($sql);
    
    }
    

    public function get_specific_activity($entry_id){
        $sql = "SELECT * FROM time_entries WHERE `entry_id` = $entry_id";

        if($result = $this->conn->query($sql)){
            return $result;
        }else{
            die("Error retrieving time entry data. ".  $this->conn->error);
        }
    }
    

    public function get_current_activity() {
        $user_id = $_SESSION['user_id'];
    
        $sql = "SELECT te.*, a.activity_name 
                FROM time_entries te 
                LEFT JOIN activities a ON te.activity_id = a.activity_id 
                WHERE te.employee_id = $user_id 
                ORDER BY te.start_time DESC 
                LIMIT 1";
    
        if ($result = $this->conn->query($sql)) {
            return $result;
        } else {
            die("Error retrieving time entry data: " . $this->conn->error);
        }
    }

    public function add_activity_remark($activity_id, $remarks) {
        // session_start();
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
    
    
    
    
}