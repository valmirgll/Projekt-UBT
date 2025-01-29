<?php
include_once "db.php";
session_start();

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function register($name, $surname, $email, $password, $role = 'user') {
        if ($this->emailExists($email)) {
            return "Email already exists!";
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->conn->prepare("INSERT INTO users (name, surname, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $surname, $email, $hashedPassword, $role);

        if ($stmt->execute()) {
            return "Registration successful! You can now <a href='login.php'>log in</a>.";
        } else {
            return "Error: " . $stmt->error;
        }
    }

    public function login($email, $password) {
        $stmt = $this->db->conn->prepare("SELECT id, name, role, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $name, $role, $hashedPassword);

        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            if (password_verify($password, $hashedPassword)) {
                $_SESSION["user_id"] = $id;
                $_SESSION["name"] = $name;
                $_SESSION["role"] = $role;

                if ($role === "admin") {
                    header("Location: admin.php");
                } else {
                    header("Location: dashboard.php");
                }
                exit();
            } else {
                return "Invalid password!";
            }
        } else {
            return "User not found!";
        }
    }

    private function emailExists($email) {
        $stmt = $this->db->conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
}
?>