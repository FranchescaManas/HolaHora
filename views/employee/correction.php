<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Correction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body style="height: 90vh">
    <?php
    include "../shared/main-nav.php";
    include "correction-modal.php";
    ?>

    <div class="d-flex align-items-start flex-column p-4 h-100">
        <h1 class="display-5 mb-3">Activity Correction</h1>

        <table class="table table-hover table-striped">
            <thead class="table-dark">
                <th>Activity</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Duration</th>
                <th></th>
            </thead>
            <tbody>
               
                <tr>
                    <td>Activity 1</td>
                    <td>###</td>
                    <td>###</td>
                    <td>###</td>
                    <td>
                        <input type="radio" name="correction_row" id="">
                    </td>
                </tr>
                <tr>
                    <td>Activity 2</td>
                    <td>###</td>
                    <td>###</td>
                    <td>###</td>
                    <td>
                        <input type="radio" name="correction_row" id="">
                    </td>
                </tr>
                <tr>
                    <td>Activity 3</td>
                    <td>###</td>
                    <td>###</td>
                    <td>###</td>
                    <td>
                        <input type="radio" name="correction_row" id="">
                    </td>
                </tr>
                <tr>
                    <td>Activity 4</td>
                    <td>###</td>
                    <td>###</td>
                    <td>###</td>
                    <td>
                        <input type="radio" name="correction_row" id="">
                    </td>
                </tr>
            </tbody>
        </table>

        <input type="submit" value="Correct Acivity" class="btn btn-primary w-100 mt-auto" data-bs-toggle="modal" data-bs-target="#correction-modal">
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>