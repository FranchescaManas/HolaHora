<?php
include "../../classes/Admin.php";


$admin = new Admin;
$activity_id = $_GET['activity_id'];

$admin->delete_activity($activity_id);
t
?>