<?php

// Database Connection
require_once('db.php');

session_start();

// LOGIN Verification
if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
    header('location: login.php');
    die();
}

// Check action of delete
if (isset($_POST['delete_btn'])) {
    $delete_id = mysqli_real_escape_string($conn, trim($_POST['delete_id']));
    $user_id = $_SESSION['user_id'];

    // Delete query of task
    $deleteExisted_task = "DELETE FROM `tasks` WHERE id = $delete_id AND user_id = $user_id ";
    $deleteTask_query = mysqli_query($conn, $deleteExisted_task);

    // If deleted redirect it to main file
    if ($deleteTask_query) {
        echo "Task Deleted Successfully";
        header('location: index.php');
        die();
    }
}
