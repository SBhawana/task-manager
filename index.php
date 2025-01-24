<?php
// Connection File
require_once('db.php');

session_start();

// LOGIN Verification
if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
    header('location: login.php');
    die();
}

echo 'Welcome ' . $_SESSION['user_name'] . '!';
// Fetch Task From Database Tables
$user_id = $_SESSION['user_id']; // User ID from session
$allTask = "SELECT * FROM `tasks` WHERE user_id = $user_id ORDER BY created_at DESC ";
$allTask_query = mysqli_query($conn, $allTask);
$result_allTask = mysqli_fetch_all($allTask_query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <!-- Bootstrap css cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Styling css -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="header d-flex justify-content-between  w-100 ">
            <!-- Add Task Form -->
            <form class="form_box d-flex" action="add_task.php" method="post">
                <input type="text" name="task" class="form-control" placeholder="Enter a new task" autofocus>
                <button class="btn btn-primary task_btn" type="submit" name="add_task">Add Task</button>
            </form>

            <!-- Logout Form -->
            <form action="logout.php" method="post">
                <input type="hidden" name="logout_id" value="">
                <button type="submit" class="btn btn-primary" name="logout_btn" value="logout">
                    Log out <i class="fa-solid fa-right-from-bracket ms-2"></i>
                </button>
            </form>
        </div>



        <!-- Table For Showing All Tasks -->
        <table class="task_table">
            <thead>
                <th>Task</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php
                if (is_array($result_allTask) && count($result_allTask)) {
                    foreach ($result_allTask as $task) {
                ?>
                        <tr>
                            <td><?= $task['task'] ?></td>
                            <td class="border-start">
                                <form action="mark_complete.php" method="post" class="d-inline">
                                    <input type="hidden" name="mark_complete" value="<?= $task['id'] ?>">

                                    <?php
                                    if ($task['is_completed'] == 1) {


                                    ?>
                                        <input type="hidden" name="completed" value="0">
                                        <button type="submit" class="btn btn-success" name="mark_btn" value="mark">Completed</button>
                                    <?php
                                    } else {
                                    ?>
                                        <input type="hidden" name="completed" value="1">
                                        <button type="submit" class="btn btn-danger" name="mark_btn" value="mark">Not Completed</button>
                                    <?php } ?>
                                </form>
                                <form action="delete_task.php" method="post" class="d-inline">
                                    <input type="hidden" name="delete_id" value="<?= $task['id'] ?>">
                                    <button type="submit" class="btn btn-danger" name="delete_btn" value="delete"><i class="icon fa-solid fa-trash-can"></i></button>
                                </form>
                            </td>
                        <?php
                    }
                } else {
                        ?>
                        <td colspan="2"><?php echo "No Task Found !" ?></td>
                    <?php
                }
                    ?>
                        </tr>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap Js cdn -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>