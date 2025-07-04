<?php
include "../../classes/Manager.php";


$manager = new Manager;
$user_id = $_GET['user_id'];

$manager->remove_employee($user_id);
t
?>