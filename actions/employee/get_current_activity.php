<?php
session_start();
include '../../classes/Employee.php';

$employee = new Employee();
$result = $employee->get_current_activity();

if ($result->num_rows > 0) {
    $activity = $result->fetch_assoc();
    
    echo json_encode([
        'success' => true,
        'activity' => $activity['activity_name'],
        'start_time' => $activity['start_time'],
        'end_time' => $activity['end_time'],
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No activity found'
    ]);
}
?>
