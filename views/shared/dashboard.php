
<!-- TODO: Utilize google charts for free charts
  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="../../assets/js/employee/chart.js"></script> 
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
            <div id="chart-container" style="width: 100%; max-width: 600px; margin: auto;">
                <div id="piechart"></div>
            </div>
        </div>
        <?php
        // table data condition based on login 
        if($_SESSION['role'] == 'E'){
            include '../../classes/Employee.php';
            $employee = new Employee;
            $activity_hours = $employee->get_activity_hours();
            $activities = $employee->get_activities();
        }
        
        ?>
        <div class="col-7">
            <table class="table table-striped table-hover mb-3">
                <thead class="table-dark">
                    <tr>
                        <th>Activity</th>
                        <?php foreach ($activity_hours as $activity) { ?>
                            <th><?= htmlspecialchars($activity[0]) ?></th> <!-- Activity Name -->
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Hours</td>
                        <?php foreach ($activity_hours as $activity) { ?>
                            <td><?= htmlspecialchars($activity[1]) ?></td> <!-- Total Hours -->
                        <?php } ?>
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
                    <?php
                    if ($activities) { ?>
                        <?php while ($log = $activities->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $log['activity_name'] ?></td>
                                <td><?= $log['start_time'] ?></td>
                                <td><?= $log['end_time'] ?? 'Ongoing' ?></td>
                                <td><?= $log['duration'] ?? 'In Progress' ?></td>
                                <td>
                                    <button type="button" class="btn view-remark-btn" data-bs-toggle="modal" data-bs-target="#view-remark" data-entry-id="<?= $log['entry_id'] ?>">
                                        <i class="fa-regular fa-message"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="4" class="text-center">No activities recorded</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        </div>
       
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>