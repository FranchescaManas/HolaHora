<?php
include "../../classes/Admin.php";


$admin = new Admin;
$manager_id = $_GET['user_id'];

$admin->delete_manager($manager_id);

?>