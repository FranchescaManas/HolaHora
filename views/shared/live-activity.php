<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 </head>
 <body style="height: 100vh;">

    <?php
    include "main-nav.php";

    ?>

    <div class="container-fluid p-3 h-100 w-75">
        <div class="row">
            <?php
            // TODO: row action buttons depending on current role logged in
            include "../manager/live-activity-actions.php";
            ?>

            <div class="row">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <th>Employee Name</th>
                        <th>Activity</th>
                        <th>Team</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Duration</th>
                    </thead>
                    <tbody>
                        <td>Employee Name</td>
                        <td>Activity 1</td>
                        <td>Team 1</td>
                        <td>Department 1</td>
                        <td>Position</td>
                        <td>###</td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 </body>
 </html>