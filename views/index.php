
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">

<div style="height: 100vh" class="d-flex flex-column justify-content-center align-items-center">
    <h1 class="display-5 fw-bold mb-5">Hola Hora</h1>
    <div class="card w-25 bg-white">
        <div class="card-body">
            <form action="../actions/user/login.php" method="post">
                <input type="text" name="username" placeholder="Username" class="form-control my-4" required autofocus>
                <input type="password" name="password" placeholder="Password" class="form-control my-4" required>

                <button type="submit" class="btn btn-primary w-100 my-5" name="btn_login">Login</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>

