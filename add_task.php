<?php
// Connection File
require_once('db.php');
session_start();
$errors = [];
include 'errors.php';
include 'success.php' ;


// LOGIN Verification
if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
    header('location: login.php');
    die();
}

// Insert task in database table
if (isset($_POST['add_task'])) {

    $task = mysqli_real_escape_string($conn, trim($_POST['task']));
    if ($task === ''){
        $errors[] = 'task cannot blank' ;
        header('location: index.php') ;
    }

    $user_id = $_SESSION['user_id'];

    // Insert task query
    if(empty($errors)){
    $insertTask = "INSERT INTO tasks(task,user_id,created_at)  VALUES ('$task' , '$user_id' , NOW())";
    $insertTask_query = mysqli_query($conn, $insertTask);

    // If insert redirect into main file
    if ($insertTask_query) {
        echo "Inserted Successfully";
        header("location: index.php");
        die();
    } else {
        echo "Not Inserted";
    }
    }
}
