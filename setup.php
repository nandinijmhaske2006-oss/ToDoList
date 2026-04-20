<?php
include 'db.php';

$sqlUsers = "CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

$sqlTasks = "CREATE TABLE IF NOT EXISTS `tasks` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `task` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'pending',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if (mysqli_query($conn, $sqlUsers) && mysqli_query($conn, $sqlTasks)) {
    // Check if user_id column exists, if not add it (simple migration)
    $checkColumn = mysqli_query($conn, "SHOW COLUMNS FROM `tasks` LIKE 'user_id'");
    if (mysqli_num_rows($checkColumn) == 0) {
        mysqli_query($conn, "ALTER TABLE `tasks` ADD COLUMN `user_id` int(11) NOT NULL AFTER `Id` ");
    }
    
    echo "<h1>Database setup successfully!</h1>";
    echo "<p>You can now go to <a href='register.php'>Register</a> or <a href='login.php'>Login</a></p>";
} else {
    echo "Error setting up database: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
