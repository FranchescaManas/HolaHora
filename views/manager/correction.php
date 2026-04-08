<?php
session_start();
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Correction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body style="height: 85vh">
    <?php
    include "../shared/main-nav.php";
    include "correction-modal.php";
    include '../../classes/Manager.php';
    $manager = new Manager; 
    // detect history mode
    $isHistory = isset($_GET['history']) && $_GET['history'] == 1;
    $activities = $manager->get_correction_request($isHistory);
    
    ?>

    <div class="d-flex align-items-start flex-column p-4 h-100">
        <!-- TITLE + HISTORY TOGGLE -->
        <h1 class="display-5 mb-3">
            <?= $isHistory ? "Activity Correction History" : "Activity Correction" ?>

            <a href="?history=<?= $isHistory ? 0 : 1 ?>"
            class="btn btn-outline-secondary btn-sm ms-2"
            title="<?= $isHistory ? "Back to Pending" : "View History" ?>">
                <i class="bi bi-clock-history"></i>
            </a>
        </h1>


        <table class="table table-hover table-striped">
            <thead class="table-dark">
                <th>Employee Name</th>
                <th>Team</th>
                <th>Activity Date</th>
                <th>Activity</th>
                <th>Request Date</th>
                 <?php if ($isHistory): ?>
                    <th>Approval Status</th>
                <?php endif; ?>
                <th></th>
            </thead>
            <tbody>
               <?php
               if ($activities) { ?>
                <?php while ($log = $activities->fetch_assoc()) { 
                    // print_r($log);
                ?>
               
                <tr>
                    <td><?= $log['employee_name'] ?></td>
                    <td><?= $log['team_name'] ?></td>
                    <td><?= $log['activity_date'] ?></td>
                    <td><?= $log['activity_name'] ?></td>
                    <td><?= $log['request_date'] ?></td>
                    <?php if ($isHistory): ?>
                    <td>
                        <?php if ($log['isApproved'] === "1" || $log['isApproved'] === 1): ?>
                            <span class="badge bg-success">Approved</span>

                        <?php elseif ($log['isApproved'] === "0" || $log['isApproved'] === 0): ?>
                            <span class="badge bg-danger">Rejected</span>

                        <?php else: ?>
                            <span class="badge bg-secondary">Pending</span>
                        <?php endif; ?>
                    </td>
                <?php endif; ?>
                    <td>
                        <button type="button" class="btn btn-primary view-btn" data-bs-toggle="modal" data-bs-target="#view-manager-correction" data-entry="<?= $log['entry_id'] ?>" data-status="<?= $log['isApproved'] ?>">View</button>
                    </td>
                   
                </tr>
                
                <?php 
            } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="4" class="text-center">No activities recorded</td>
                        </tr>
                    <?php } ?>
            </tbody>
        </table>

        <!-- <input type="submit" id="correct_btn" value="Correct Acivity" class="btn btn-primary w-100 mt-auto"> -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../../assets/js/manager/correction-modal.js"></script>
</body>
</html>