<?php
include "../../classes/Employee.php";


$employee = new employee;


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $entry_id = $_POST['entry_id'];
    $remarks = $_POST['remarks'];

    if ($entry_id && !empty($remarks)) {
        $employee = new Employee();
        $success = $employee->add_activity_remark($entry_id, $remarks);

        if ($success) {
            echo json_encode(["status" => "success", "message" => "Remark updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update remark"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid input"]);
    }
}
else{
    echo json_encode(["status" => "error"]);
}
?>