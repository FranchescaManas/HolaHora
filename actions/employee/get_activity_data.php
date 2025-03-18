<?php
include '../../classes/Employee.php';
$employee = new Employee;
session_start();

echo json_encode($employee->get_activity_hours());
?>
