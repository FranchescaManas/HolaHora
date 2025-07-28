<?php
include "../../classes/Admin.php";


$admin = new Admin;
$employee_id = $_GET['user_id'];

$admin->delete_employee($employee_id);
?>