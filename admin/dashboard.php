<?php
include('../config.php');
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Admin dashboard content
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, Admin <?php echo $_SESSION['username']; ?>!</h1>
    <ul>
        <li><a href="manage_courses.php">Manage Courses</a></li>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
