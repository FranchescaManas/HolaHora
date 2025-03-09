<?php
include "../../classes/Employee.php";


$employee = new employee;

$shift_type = $_POST["shift"];

header("location: ./shift-activity.php");

// $employee->shift($shift_type); 
?>