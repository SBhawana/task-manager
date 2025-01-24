<?php

// Database connection
require_once 'db.php';

// Initiate the array for further using  like errors , success
$errors = [];
$success = '';
$name = '';
$email = '';
$password = '';

// Initialise the data
if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    // Validation of data
    if ($name === '') {
        $errors[] = 'Name cannot be blank.';
    }
    if ($email === '') {
        $errors[] = 'Email cannot be blank.';
    }
    if ($password === '') {
        $errors[] = 'password cannot be blank.';
    }
    if (!(is_string($password) && strlen($password) > 4)) {
        $errors[] = 'Invalid password, it must be length more than 4 digits';
    }

    // If no error then data verify with database if verified then insert
    if (empty($errors)) {
        $hash_password = md5($password);
        $existedUser = "SELECT * FROM users WHERE email = '$email' ";
        $existedUser_sql = mysqli_query($conn, $existedUser);

        if (mysqli_num_rows($existedUser_sql) > 0) {
            $errors[] = 'User already Exist.';
        } else {
            $insertUser = "INSERT INTO users (name,email,password) VALUES ('$name' , '$email' , '$hash_password') ";
            $insertUser_sql = mysqli_query($conn, $insertUser);

            if ($insertUser_sql) {
                $success = 'User Inserted Successfully';
                header('location: login.php');
                die();
            } else {
                $errors[] = 'Something Went Wrong! Try Again';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register For Task Manager</title>
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

    <!-- Registration Form -->
    <div class="container">
        <h2 class="fw-bold text-danger mb-3">Welcome To Registration</h2>
        <form class="w-100" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="mb-3">
                <label for="name" class="form-label float-start fw-bold">Enter Your Name :</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $name ?>" required autofocus>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label float-start fw-bold">Enter Your Email :</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label float-start fw-bold">Enter Your Password :</label>
                <input type="password" class="form-control" id="password" name="password" value="<?= $password ?>" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary float-start w-30" name="register">Register</button>
            <a href="login.php" class="float-start ps-3 mt-2">If already register go for login</a>
        </form>
    </div>
</body>

</html>