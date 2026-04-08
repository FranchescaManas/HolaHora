<?php
session_start();
header('Content-Type: application/json');

include "../../classes/Employee.php";

$employee = new Employee();


$entry_id = $_POST["entry_id"] ?? null;
$remarks = $_POST["remarks"] ?? null;
$end_time = $_POST["end_time"] ?? null;
$start_time = $_POST["start_time"] ?? null;
$requested_date = $_POST["requested_date"] ?? null;
$manager_id = $_POST["manager_id"] ?? null;
$activity_id = $_POST["activity_id"] ?? null;

if (!$entry_id || !$end_time) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit;
}

// Your create function
$success = $employee->create_correction_request([
    "entry_id" => $entry_id,
    "remarks" => $remarks,
    "start_time" => $start_time ?? null,
    "end_time" => $end_time,
    "requested_date" => $requested_date,
    "user_id" => $_SESSION['user_id'],
    "manager_id" => $manager_id,
    "activity_id" => $activity_id
]);
$result = json_decode($success, true);
if ($success && $result['status'] === 'success') {
    // echo json_encode(["status" => "success", "message" => "Correction request created"]);
    echo json_encode(["status" => "success", "message" => $result['message']]);
} else {
    echo json_encode(["status" => "error", "message" => $result ? $result['message'] : "Database error"]);
}

exit;

