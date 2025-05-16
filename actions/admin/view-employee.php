<?php
include "../../classes/Admin.php";

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $admin = new Admin();
    $employee = $admin->get_employee_details($user_id);

    // header('Content-Type: application/json');
    echo json_encode($employee);
} else {
    echo json_encode(['error' => 'User ID not provided']);
}
?>
