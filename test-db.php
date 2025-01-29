<?php
include_once "db.php";

$db = new Database();

if ($db->conn->connect_error) {
    die("Database connection failed: " . $db->conn->connect_error);
} else {
    echo "✅ Database connected successfully!";
}
?>