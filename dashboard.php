<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "user") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION["name"]; ?>!</h2>
    <a href="logout.php">Logout</a>
</body>
</html>