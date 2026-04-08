<?php
include "../../classes/Admin.php";


$admin = new Admin();

$result = $admin->create_manager($_POST);

if ($result[0]) {
    echo "<script>
            alert('Manager created successfully!');
            window.location.href='../../views/admin/team-management.php';
          </script>";
} else {
    echo "<script>
            alert('Error creating manager: ".$result[1]."');
            window.location.href='../../views/admin/team-management.php';
          </script>";
}




?>