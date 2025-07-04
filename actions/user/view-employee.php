<?php
include "../../classes/User.php";

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $user = new User();
    $employee = $user->get_employee_details($user_id);

    // header('Content-Type: application/json');
    echo json_encode($employee);
} else {
    echo json_encode(['error' => 'User ID not provided']);
}
?>
