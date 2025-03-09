
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body style="height: 100vh; border: 1px solid red">
<?php 
include '../shared/main-nav.php';
include "view-remark-modal.php";
$role = $_SESSION['role'];
?>

<div class="container-fluid w-75 px-3 border border-1 " style="height:80vh">

    <div class="row justify-content-evenly h-100">
        <div class="col-5 border border-1 px-0">
           
            <?php
                include "dashboard-chart-menu.php";
            ?>
            <div class="chart-container">
                chart here
            </div>
        </div>
           
        <div class="col-7">
            <table class="table table-striped table-hover mb-3">
                <thead class="table-dark">
                    <th>Activity </th>
                    <th>Activity 1</th>
                    <th>Activity 2</th>
                    <th>Activity 3</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Hours</td>
                        <td>#####</td>
                        <td>#####</td>
                        <td>#####</td>
                    </tr>
                    
                </tbody>
            </table>

            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <th>Activity </th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Duration</th>
                    <th></th>
                </thead>
                <tbody>
                    <tr>
                        <td>Activity 1</td>
                        <td>#####</td>
                        <td>#####</td>
                        <td>#####</td>
                        <td>
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#view-remark">
                                <i class="fa-regular fa-message"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
       
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>