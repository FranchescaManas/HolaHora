<?php
include "../../classes/Admin.php";


$admin = new Admin;
// Ensure `employees` is always an array
// $employees = isset($_POST['employees']) ? $_POST['employees'] : [];

// print_r($_POST);
$admin->edit_team($_POST);
?>