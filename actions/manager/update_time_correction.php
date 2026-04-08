<?php
session_start();
header('Content-Type: application/json');

include "../../classes/Manager.php";

$manager = new Manager();


$isApproved = $_POST["status"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];
$request_id = $_POST["request_id"];

$success = $manager->update_correction_entry($request_id, $start_time, $end_time,$isApproved);


if ($success) {
   
    echo json_encode([
        "status" => "success",
        "data" => $_POST
    ]);
} else {
     echo json_encode([
        "status" => "error",
        "message" => "Database error"
    ]);
}

exit;

