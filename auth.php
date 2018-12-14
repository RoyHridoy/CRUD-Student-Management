<?php
//session_name('crudStudentManagement');
session_start();
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

$error = false;
$fp    = fopen('./data/users.txt', 'r');

if ($username && $password) {
    while ($data = fgetcsv($fp)) {
        if ($data[0] == $username && $data[1] == sha1($password)) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['user']     = $username;
            $_SESSION['role'] = $data[2];
            header('location: index.php');
        }
    }
    if (!isset($_SESSION['loggedIn'])) {
        $error = true;
    }
}
fclose($fp);

if (isset($_SESSION['loggedIn'])) {
    header('location: index.php');
}

if (isset($_GET['logout'])) {
    $_SESSION['loggedIn'] = false;
    session_destroy();
    header('location: index.php');
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - CRUD Student Management</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="./inc/templates/style.css">
</head>
<body>

<div class="login-area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-6 offset-3">
                <h3 class="text-center text-uppercase">login area</h3>
                <?php
                if ($error) {
                    echo "<div class='alert alert-danger' role='alert'>
    	                    <strong>username and password doesn't match</strong>
    	                </div>";
                }
                ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="assets/script.js"></script>
</body>
</html>