<?php
include_once "../../classes/Manager.php";

$manager = new Manager();

if (isset($_POST['query'])) {
    $search = $_POST['query']; 
    $manager->search_employee($search); // Pass only the search term
}
?>
