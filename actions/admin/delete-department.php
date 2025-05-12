<?php
include "../../classes/Admin.php";


$admin = new Admin;
$department_id = $_GET['department_id'];

$admin->delete_department($department_id);
t
?>