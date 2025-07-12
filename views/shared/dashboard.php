<?php
session_start();
?>
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
    <script type="text/javascript" src="../../assets/js/shared/chart.js"></script> 

</head>
<body style="height: 100vh; border: 1px solid red">
<?php 

include '../shared/main-nav.php';
include "view-remark-modal.php";

?>
<!-- TODO: MANAGER CANT SEE ANYTHING WITH DATA LESS THAN AN HOUR -->
<div class="container-fluid w-75 px-3" style="height:80vh">
    
    <div class="row justify-content-evenly h-100 border">
        <div class="col-5 border-end">
            
            <?php
                include "dashboard-chart-menu.php";
                ?>
            <div id="chart-container" style="width: 100%; max-width: 600px; margin: auto;">
                
                <div id="piechart"></div>
            </div>
        </div>
        <?php
        
        $user = new User;

        $activity_hours = $user->get_activity_hours();
        $activities = $user->get_activity_dashboard();
        
        ?>
        <div class="col-7 h-100 d-flex flex-column">
            <div class="row flex-shrink-0">

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
            </div>

            <div class="row flex-grow-1 overflow-auto">
                                
                <table class="table table-striped table-hover mb-0" >
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
<script src="../../assets/js/employee/activity.js"></script>
<script src="../../assets/js/shared/activity-modal.js"></script>
<script src="../../assets/js/admin/activity.js"></script>
</body>
</html>