<?php
include "../../classes/Employee.php";


$employee = new employee;

// Check which action was triggered
if (isset($_POST['btn_activity'])) {
    $employee->update_activity($_POST);
} elseif (isset($_POST['btn_shift'])) {
    $shift_type = $_POST["btn_shift"];
    $employee->shift($_POST);
} else {
    die("Invalid request.");
}
?>