<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';
$user_id = $_SESSION['user_id'];

// Only delete tasks for the current user (instead of TRUNCATE which clears everyone's)
$stmt = $conn->prepare("DELETE FROM tasks WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$success = $stmt->execute();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html> 
<head> 
    <title>Clear Tasks History</title> 
    <style> 
        body { 
            background-image: url("Images/clear.png"); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            height: 100vh; 
            width: 100vw; 
            margin: 0; 
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        } 
    </style> 
</head> 
<body> 
    <script> 
        <?php if ($success): ?>
            alert('Your tasks history has been cleared!'); 
        <?php else: ?>
            alert('Failed to clear history. Please try again.');
        <?php endif; ?>
        
        window.location.href = 'index.php'; 
    </script> 
</body> 
</html> 
