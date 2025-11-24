<?php
include "../../classes/Employee.php";

if (isset($_GET['entry_id'])) {
    $employee = new Employee();
    $entry_id = $_GET['entry_id'];
    $result = $employee->get_specific_activity($entry_id);
    $manager_name = $employee->get_manager();

    if ($result->num_rows > 0) {
        $activity = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'activity_name' => $activity['activity_name'],
            'start_time' => $activity['start_time'],
            'end_time' => $activity['end_time'],
            'duration' => $activity['duration'],
            'remarks' => $activity['remarks'],
            'manager' => $manager_name
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No activity found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
