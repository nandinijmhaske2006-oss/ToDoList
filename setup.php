<?php
include 'db.php';

$sql = "CREATE TABLE IF NOT EXISTS `tasks` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `task` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'pending',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if (mysqli_query($conn, $sql)) {
    echo "<h1>Table created successfully!</h1>";
    echo "<p>You can now go back to <a href='index.php'>your To-Do List</a></p>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
