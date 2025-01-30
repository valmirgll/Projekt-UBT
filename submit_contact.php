<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gunshop";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$photo = $_FILES['photo']['name'];


$targetDir = "uploads/";
$targetFilePath = $targetDir . basename($photo);
move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath);

$sql = "INSERT INTO messages (name, email, message, photo) VALUES ('$name', '$email', '$message', '$photo')";

if ($conn->query($sql) === TRUE) {
    echo "Message sent successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>