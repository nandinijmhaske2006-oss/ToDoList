<?php
ob_start();
session_start();

// Protection: Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';
$user_id = $_SESSION['user_id'];

// Handle Add Task
if (isset($_POST["add"])) {
    $task = $_POST["task"];
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, task, status) VALUES (?, ?, 'pending')");
    $stmt->bind_param("is", $user_id, $task);

    if (!$stmt->execute()) {
        echo "<script> alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Delete Task
if (isset($_POST["delete"])) {
    $task_id = (int) $_POST['task_id'];
    $stmt = $conn->prepare("UPDATE tasks SET status = 'deleted' WHERE Id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);

    if (!$stmt->execute()) {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Complete Task
if (isset($_POST["completed"])) {
    $task_id = (int) $_POST['task_id'];
    $stmt = $conn->prepare("UPDATE tasks SET status = 'completed' WHERE Id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);

    if (!$stmt->execute()) {
        echo "<script> alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Greeting Logic
$hour = date('H');
if ($hour < 12) {
    $greeting = "Good Morning";
} elseif ($hour < 18) {
    $greeting = "Good Afternoon";
} else {
    $greeting = "Good Evening";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>

    <!-- css -->
    <link rel="stylesheet" type="text/css" href="style.css?v=1.1">

</head>

<body>

    <div class="container">
        <div class="topheader">
            <div>
                <h2 style="margin-bottom: 5px;">To-Do List</h2>
                <small style="color: #666; font-family: Arial, sans-serif;">
                    <?php echo $greeting . ", " . htmlspecialchars($_SESSION['username']); ?>! 📝
                </small>
            </div>
            <form name="generatepdf">
                <label for="menu-toggle">
                    <svg id="checklist" viewBox="0 0 24 24" fill="none" stroke="#2c3e50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg>
                </label>
                <!-- Hidden Checkbox  -->
                <input type="checkbox" id="menu-toggle">

                <div class="menu">
                    <a href="Report.php">Report</a>
                    <a href="clear_history.php">Clear History</a>
                    <a href="logout.php" style="color: #ff5a4f; border-top: 1px solid #eee;">Logout</a>
                </div>
            </form>
        </div>
        <form method="post" name="AddTaskForm">
            <div class="task-input">
                <input type="text" name="task" placeholder="Add your task" required>
                <button value="ADD" name="add">ADD</button>
            </div>
        </form>

        <div class="task-container">
            <ul id="tasklist">
                <?php
                // Fetch user-specific tasks
                $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? AND status != 'deleted' ORDER BY Id DESC");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
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
                                    <button name='delete' class='delete-btn'>
                                        <svg viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                                            <polyline points='3 6 5 6 21 6'></polyline>
                                            <path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path>
                                            <line x1='10' y1='11' x2='10' y2='17'></line>
                                            <line x1='14' y1='11' x2='14' y2='17'></line>
                                        </svg>
                                    </button>
                                </li> 
                            </form>";
                    }
                }
                $stmt->close();
                $conn->close();
                ?>

            </ul>
        </div>

    </div>

</body>

</html>