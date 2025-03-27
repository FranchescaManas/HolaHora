<?php
include_once "../../classes/Admin.php";

$admin = new Admin();

if (isset($_POST['query'])) {
    $search = $_POST['query']; 
    $admin->search_employee($search); // Pass only the search term
}
?>
