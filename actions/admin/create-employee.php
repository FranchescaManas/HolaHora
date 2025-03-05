<?php
include "../../classes/Admin.php";


$admin = new Admin;

$admin->create_employee($_POST);
?>