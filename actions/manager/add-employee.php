<?php
session_start();
include "../../classes/Manager.php";

if (isset($_POST['team_id'], $_POST['employees'])) {
    $team_id = $_POST['team_id'];
    $employees = $_POST['employees'];

    $manager = new Manager;
    foreach ($employees as $user_id => $data) {
        $manager->add_employee_to_team($team_id, $user_id);
    }

    echo "Employees added successfully!";
} else {
    echo "Invalid request!";
}
?>
