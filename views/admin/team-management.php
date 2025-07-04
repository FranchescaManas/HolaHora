<?php

include_once "../../classes/Admin.php";


$admin = new Admin;

$admin->get_department();
$all_teams = $admin->get_teams();
$all_department = $admin->get_department();

$departments = [];
while ($department_select = $all_department->fetch_assoc()) {
    $departments[] = $department_select; // Store results in an array
}

$teams = [];
while ($team_select = $all_teams->fetch_assoc()) {
    $teams[] = $team_select; // Store results in an array
}

$all_employees = $admin->get_all_employees()


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="border border-1 border-danger" style="height: 100vh">

<?php 
include '../shared/main-nav.php';
include 'create-department.php';
include 'create-manager-modal.php';
include 'create-employee-modal.php';


?>

<div class="container h-75 w-75 overflow-auto">

    <div class="row justify-content-end mb-2">
        <button type="button" class="btn btn-primary w-auto ms-2" data-bs-toggle="modal" data-bs-target="#create-manager-modal">
            <!-- <i class="fa-solid fa-user-tie"></i> -->
            <i class="fa-solid fa-user-tie me-1"></i> Add Manager
        </button>
        <button type="button" class="btn btn-primary w-auto ms-2" data-bs-toggle="modal" data-bs-target="#create-employee-modal">
            <!-- <i class="fa-solid fa-user-plus"></i> -->
            <i class="fa-solid fa-user-plus me-1"></i> Add Employee
        </button>
        <a href="create-team.php" class="btn btn-primary ms-2 w-auto">
            <!-- <i class="fa-solid fa-users-line"></i> -->
            <i class="fa-solid fa-people-group me-1"></i> Create Team
        </a>
        <button type="button" class="btn btn-primary w-auto ms-2" data-bs-toggle="modal" data-bs-target="#create-department">
            <!-- <i class="fa-solid fa-people-roof"></i> -->
            <i class="fa-solid fa-building me-1"></i> Departments
        </button>
      

        <div class="dropdown w-auto px-0 ms-2">
               <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                  <i class="fa-solid fa-filter"></i>
               </button>
               <form class="dropdown-menu p-4">
                  <div class="mb-3">
                     <label for="exampleDropdownFormEmail2" class="form-label">Status</label>
                     <select name="team_filter" id="" class="form-select">
                        <option value="" hidden>Select Status</option>
                        <option value="" >Active</option>
                        <option value="" >Inactive</option>
                     </select>
                  </div>
                 
                  <div class="mb-3">
                     <label for="exampleDropdownFormEmail2" class="form-label">Team</label>
                     <select name="team_filter" id="" class="form-select">
                        <option value="" hidden>Select Team</option>
                        <?php foreach ($teams as $team) { ?>
                                <option value="<?= $team['team_id'] ?>"><?= $team['team_name'] ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Save</button>
               </form>
            </div>
    </div>

    <div class="row flex-grow-1 overflow-auto">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-dark">
                <th>Team</th>
                <th>Status</th>
                <th>Manager</th>
                <th>Department</th>
                <th></th>
            </thead>
            <tbody>
                <?php
                foreach ($teams as $team){
                ?>
                <tr>
                    <td class="align-middle"><?= $team['team_name']?></td>
                    <td class="align-middle"><?= $team['status']?></td>
                    <td class="align-middle"><?= $team['name']?></td>
                    <td class="align-middle"><?= $team['department_name']?></td>
                    <td>
                        <a href="../../views/admin/view-team.php?team_id=<?=$team['team_id']?>" class="btn bg-none border-0">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                    
                        <a href="../../views/admin/edit-team.php?team_id=<?=$team['team_id']?>" class="btn bg-none border-0">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                    
                        
                        <a href="../../actions/admin/delete-team.php?team_id=<?=$team['team_id']?>" class="btn bg-none border-0">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                        
                    </td>
                </tr>

                <?php
                }
                ?>
                

            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>