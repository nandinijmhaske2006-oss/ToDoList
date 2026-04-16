<?php
ob_start(); // Start output buffering at the beginning
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>

    <!-- css -->
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

    <div class="container">
        <div class="topheader">
            <h2>To-Do List</h2>
            <form name="generatepdf">
                <label for="menu-toggle">
                    <img src="Images/checklist.png" id="checklist" alt="img">
                </label>
                <!-- Hidden Checkbox  -->
                <input type="checkbox" id="menu-toggle">

                <div class="menu">
                    <a href="Report.php">Report</a>
                    <a href="clear_history.php">Clear History</a>

                </div>
            </form>
        </div>
        <form method="post" name="AddTaskForm">
            <div class="task-input">
                <input type="text" name="task" placeholder="Add your task" required>
                <button value="ADD" name="add">ADD</button>
            </div>
        </form>

        <?php

        if (isset($_POST["add"])) {
            $task = $_POST["task"];
            $conn = mysqli_connect("your-db-host", "user", "password", "database");
            if (!$conn) {
                echo "<script> alert('Database connection failed: " .
                    mysqli_connect_error() . "');</script>";
            }
            $sql = "INSERT INTO tasks (task, status) VALUES ('$task', 'pending')";
            if (!mysqli_query($conn, $sql)) {
                echo "<script> alert('Error: " . $sql . "<br>" . mysqli_error($conn)
                    . "');</script>";
            }

            mysqli_close($conn);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();

        }

        ?>

        <div class="task-container">
            <ul id="tasklist">
                <?php
                $conn = mysqli_connect("localhost", "root", "", "php micro project");
                if (!$conn) {
                    echo "<script> alert('Database connection failed: " .
                        mysqli_connect_error() . "');</script>";
                }
                $sql1 = "SELECT * FROM tasks where status != 'deleted'";
                $result = mysqli_query($conn, $sql1);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<form method='post'> 
                                <li>
                                    <div class='format'>
                                        <button class='task-btn " . ($row['status'] ==
                            'completed' ? "completed-task" : "") . "' name='completed'>
                                        </button>
                                        <div class='format-task-area " . ($row['status']
                            == 'completed' ? "long-strike" : "") . " '>" . htmlspecialchars($row['task']) . "</div>
                                    </div>
                                    <input type='hidden' name='task_id' value='" .
                            htmlspecialchars($row['Id']) . "'>
                                    <button name='delete' class='delete-btn'></button>
                                </li> 
                            </form>";


                    }

                } else {
                    // Only show alert if there is no task found at all
                    // echo "<script> alert('Task not available');</script>";
                }



                // Deleted
                if (isset($_POST["delete"])) {
                    $task_id = (int) $_POST['task_id'];
                    $sql = "UPDATE tasks SET status = 'deleted' WHERE Id = $task_id";
                    if (!mysqli_query($conn, $sql)) {
                        echo "<script>alert('Error: " . mysqli_error($conn) .
                            "');</script>";
                    } else {
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    }
                }



                // completed
                if (isset($_POST["completed"])) {
                    $task_id = (int) $_POST['task_id'];
                    $sql4 = "UPDATE tasks SET status = 'completed' WHERE Id = $task_id";

                    if (!mysqli_query($conn, $sql4)) {
                        echo "<script> alert('Error: " . $sql4 . "<br>" .
                            mysqli_error($conn) . "');</script>";
                    } else {
                        header("Location: " . $_SERVER['PHP_SELF']); // Redirect instead 
                        exit(); // Ensure no further execution after redirection
                    }

                }
                mysqli_close($conn);
                ?>

            </ul>
        </div>

    </div>

</body>

</html>
