<?php
session_start();
?>
<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
 </head>
 <body class="border border-1 border-danger" style="height: 100vh">

   <?php 
   include "../shared/main-nav.php";
   include "../../classes/Admin.php";
   include '../shared/view-employee-modal.php';
   


   $admin = new Admin;
   
   // include "add-employee-modal.php";

   // $team_employees = $admin->get_team_employees();
   $employee_list = $admin->get_employee_list();

   $employees = [];
   $positions = [];
   $teams = [];


   while ($row = $employee_list->fetch_assoc()) {
      $employees[] = $row;
      $position = $row['position'];
      $team = $row['team'] ?? 'Unassigned';

       if (!in_array($position, $positions)) {
        $positions[] = $position;
      }
      if (!in_array($team, $teams)) {
         $teams[] = $team;
      }
   }

   
   

   ?>
   <div class="container h-75 w-75 ">
      
         
         
         <div class="row">
            <table class="table table-hover table-striped">
               <thead class="table-dark">
                  <th>Employee Name</th>
                  <th>Position</th>
                  <th>Team</th>
                  <th>Manager</th>
                  <th>Department</th>
                  <th></th>
               </thead>
               <tbody>
                  <?php
                  foreach ($employees as $row):
                  ?>
                  <tr data-user-id="<?=$row['user_id'];?>">
                     <td class="align-middle"><?= $row['firstname']. ' ' . $row['lastname']?></td>
                     <td class="align-middle"><?= $row['position']?></td>
                     <td class="align-middle"><?= $row['team']?></td>
                     <td class="align-middle"><?= $row['manager_firstname']. ' ' . $row['manager_lastname']?></td>
                     <td class="align-middle"></td>
                     <td>
                        <!-- View button -->
                        <button 
                        type="button" 
                        class="btn btn-sm view-employee" 
                        data-user-id="<?= $row['user_id']; ?>" 
                        data-bs-toggle="modal" 
                        data-bs-target="#view-employee-modal">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </button>

                        <!-- Edit button -->
                        <button 
                        type="button" 
                        class="btn btn-sm view-employee" 
                        data-user-id="<?= $row['user_id']; ?>" 
                        data-bs-toggle="modal" 
                        data-bs-target="#edit-employee-modal">
                        <i class="fa-regular fa-pen-to-square"></i>
                        </button>

                     <!-- TODO: DELETE BUTTON SHOULD REMOVE EMPLOYEE FROM THE TEAM, NOT FROM THE DATABASE -->
                            <a href="../../actions/admin/delete-employee.php?user_id=<?=$row['user_id']?>"
                              class="btn bg-none border-0">
                                 <i class="fa-solid fa-trash"></i>
                            </a> 
                     </td>
                  </tr>
                  <?php
                  endforeach;
                  ?>
                  
               </tbody>
            </table>
         </div>
         

   </div>
   <?php
   include '../shared/edit-employee-modal.php';
   ?>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   <script src="../../assets/js/manager/team-management.js"></script>
   <script src="../../assets/js/shared/employee-detail.js"></script>

 </body>
 </html>