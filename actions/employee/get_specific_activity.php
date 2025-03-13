<?php
include "../../classes/Employee.php";

if (isset($_GET['entry_id'])) {
    $employee = new Employee();
    $entry_id = $_GET['entry_id'];
    $result = $employee->get_specific_activity($entry_id);

    if ($result->num_rows > 0) {
        $activity = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'start_time' => $activity['start_time'],
            'end_time' => $activity['end_time'],
            'duration' => $activity['duration'],
            'remarks' => $activity['remarks']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No activity found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
