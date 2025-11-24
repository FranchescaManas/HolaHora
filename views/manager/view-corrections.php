<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Time Adjustments</title>
</head>
<body>
    <?php 
   include "../shared/main-nav.php";
   include "../../classes/Manager.php";
   include '../shared/view-employee-modal.php';
   


   $manager = new Manager;
   ?>


    <div class="container h-75 w-75 ">
        <h3 class="mx-0 p-0">Time Corrections</h3 class="mx-0 p-0">
        <div class="row">
            <table class="table table-hover table-striped">
               <thead class="table-dark">
                  <th>Employee Name</th>
                  <th>Status</th>
                  <th>Position</th>
                  <th>Team</th>
                  <th></th>
               </thead>
               <tbody>
                  <?php
                //   foreach ($employees as $row):
                  ?>
                  <tr data-user-id="">
                     <td class="align-middle">--</td>
                     <td class="align-middle">--</td>
                     <td class="align-middle">--</td>
                     <td class="align-middle">--</td>
                     <td>
                        <!-- View button -->
                        <button 
                        type="button" 
                        class="btn btn-sm view-employee" 
                        data-user-id="" 
                        data-bs-toggle="modal" 
                        data-bs-target="#view-employee-modal">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </button>


                    
                     </td>
                  </tr>
                  <?php
                //   endforeach;
                  ?>
                  
               </tbody>
            </table>
         </div>
    </div>
</body>
</html>