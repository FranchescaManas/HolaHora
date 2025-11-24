<?php
session_start();
header('Content-Type: application/json');

include "../../classes/Employee.php";

$employee = new Employee();


$entry_id = $_POST["entry_id"] ?? null;
$remarks = $_POST["remarks"] ?? null;
$end_time = $_POST["end_time"] ?? null;
$requested_date = $_POST["requested_date"] ?? null;

if (!$entry_id || !$end_time) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit;
}

// Your create function
$success = $employee->create_correction_request([
    "entry_id" => $entry_id,
    "remarks" => $remarks,
    "end_time" => $end_time,
    "requested_date" => $requested_date,
    "user_id" => $_SESSION['user_id']
]);

if ($success) {
    echo json_encode(["status" => "success", "message" => "Correction request created"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error"]);
}

exit;

