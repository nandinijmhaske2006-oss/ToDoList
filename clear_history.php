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
        } 
    </style> 
</head> 
<body> 
</body> 
</html> 
 
<?php 
$conn = mysqli_connect("localhost", "root", "", "php micro project"); 
if (!$conn) { 
    die("Connection failed: " . mysqli_connect_error()); 
} 
 
$sql = "TRUNCATE TABLE tasks"; 
if (mysqli_query($conn, $sql)) { 
    echo "<script> 
        alert('Tasks history cleared!'); 
        if (document.referrer) { 
            window.history.back(); 
        } else { 
            window.location.href = 'TodoList.php'; 
        } 
    </script>"; 
    exit; 
} 
 
mysqli_close($conn); 
?> 
