<?php

// Database connection 
require_once('db.php');

if (isset($_POST['mark_btn'])) {
    $mark_complete = mysqli_real_escape_string($conn, trim($_POST['mark_complete']));
    $check_complete = mysqli_real_escape_string($conn, trim($_POST['completed']));

    // Update query
    $markTask = "UPDATE `tasks` SET `is_completed`= '$check_complete' WHERE id = $mark_complete";
    $markTask_query = mysqli_query($conn, $markTask);

    // If update redirect to main file
    if ($markTask_query) {
        echo "Update Successfully";
        header('location: index.php');
        die();
    } else {
        echo "Something Went Wrong";
    }
}
