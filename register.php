<?php
include_once "db.php";

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function register($name, $surname, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->conn->prepare("INSERT INTO users (name, surname, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $surname, $email, $hashedPassword);

        if ($stmt->execute()) {
            return "Registration successful! You can now <a href='Login-form.html'>log in</a>.";
        } else {
            return "Error: " . $stmt->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($surname) || empty($email) || empty($password)) {
        echo "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
    } elseif (strlen($password) < 6) {
        echo "Password must be at least 6 characters!";
    } else {
        $user = new User();
        echo $user->register($name, $surname, $email, $password);
    }
}
?>