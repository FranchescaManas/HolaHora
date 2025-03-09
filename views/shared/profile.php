<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="bg-light">
<?php 
include '../shared/main-nav.php';

include "../../classes/User.php";
$user = new User;
$user_details = $user->get_profile();
?>

    <div style="height: 85vh" class="d-flex flex-column justify-content-center align-items-center">
        <div class="card w-50 bg-white">
            <div class="card-body">
                
                <form action="" method="post">
                
                    <div class="row">
                        <div class="col">
                            <input type="text" name="Profile" placeholder="Image" class="form-control my-4" required autofocus>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="text" name="firstname" value="<?= $user_details['firstname']?>" class="form-control my-4" required autofocus>
                            <input type="text" name="username" placeholder="Username" class="form-control my-4" required autofocus>
                            <input type="text" name="contact" placeholder="Contact Information" class="form-control my-4" required autofocus>
                        </div>
                        <div class="col">
                            <input type="password" name="lastname" placeholder="Lastname" class="form-control my-4" required>
                            <input type="password" name="email" placeholder="Email" class="form-control my-4" required>

                        </div>
                    </div>
                    <div class="row ">
                       
                        <div class="col"></div>
                        <div class="col d-flex">
                            <button type="submit" class="btn btn-primary w-50" >Save</button>
                            <button type="button" class="btn btn-danger w-50 mx-2">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>