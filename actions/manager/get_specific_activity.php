<?php
include "../../classes/Manager.php";

if (isset($_GET['entry_id'])) {
    $manager = new Manager();
    $entry_id = $_GET['entry_id'];
    $result = $manager->get_specific_activity($entry_id);
    

    if ($result->num_rows > 0) {
        $activity = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'initial_start_time' => $activity['initial_start_time'],
            'start_time' => $activity['start_time'],
            'requested_start_time' => $activity['requested_start_time'],
            'name' => $activity['employee_name'],
            'duration' => $activity['duration'],
            'request_id' => $activity['request_id'],
            'activity_name' => $activity['activity_name'],
            'end_time' => $activity['initial_end_time'],
            'remarks' => $activity['remarks'],
            'requested_end_time' => $activity['requested_end_time'],
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No activity found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
