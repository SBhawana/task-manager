<?php

// Database connection 
require_once 'db.php';

// Initiate the array for further using  like errors , success
$errors = [];
$success = '';
$email = '';
$password = '';

// Session Start 
session_start();

// Initialize the data
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    // Validation of data
    if ($email === '') {
        $errors[] = 'Email cannot be blank.';
    }
    if ($password === '') {
        $errors[] = 'password cannot be blank.';
    }
    if (!(is_string($password) && strlen($password) > 4)) {
        $errors[] = 'Invalid password, it must be length more than 4 digits';
    }

    // If no error then
    if (empty($errors)) {
        $hash_password = md5($password);
        $existed_User = "SELECT * FROM users ````WHERE email = '$email' AND password = '$hash_password'";
        $existed_User_sql = mysqli_query($conn, $existed_User);
        if (mysqli_num_rows($existed_User_sql) === 1) {
            $user = mysqli_fetch_assoc($existed_User_sql);
            // Store User Data
            $_SESSION['is_login'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            $success = 'Welcome To Task Manager.';
            header('location: index.php');
        } else {
            $errors[] = 'No data found with that email';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login For Task Manager</title>
    <!-- Bootstrap css cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Styling css -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Include error file & success file -->
    <?php include 'errors.php';
    include 'success.php' ?>

    <!-- Login Form -->
    <div class="container">
        <h2 class="fw-bold text-danger">Welcome To Login</h2>
        <form class="w-100" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">

            <div class="mb-3">
                <label for="email" class="form-label float-start fw-bold">Enter Your Email :</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label float-start fw-bold">Enter Your Password :</label>
                <input type="password" class="form-control" id="password" name="password" value="<?= $password ?>" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary  float-start w-30" name="login">Login</button>
            <a href="register.php" class="float-start ps-3 mt-2">If not register go for registration</a>
        </form>
    </div>






</body>

</html>