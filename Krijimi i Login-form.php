<?php
include_once "user.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $user = new User();
    $result = $user->login($email, $password);
    
    if ($result === "admin") {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit;
    } elseif ($result === "user") {
        $_SESSION['user_logged_in'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $login_error = "Invalid login credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="POST">
        <button class="back"><a href="index.php">Home</a></button>
        <section class="wrapper">
            <h2>Login Form</h2>
            <div class="input-field">
                <input type="email" name="email" id="email" required>
                <label>Enter your email</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" id="password" required>
                <label>Enter your password</label>
            </div>
            <div class="forget">
                <label for="remember">
                    <input type="checkbox" id="remember">
                    <p>Remember me</p>
                </label>
                <a href="#">Forgot password?</a>
            </div>
            <div id="errorMessages" style="color: red;">
                <?php if (isset($login_error)) echo $login_error; ?>
            </div>
            <button type="submit">Log In</button>
            <div class="register">
                <p>Don't have an account? <a href="Register-Form.html">Register</a></p>
            </div>
        </section>
    </form>
    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value.trim();
            const errorMessages = document.getElementById("errorMessages");

            errorMessages.innerHTML = "";

            if (!email || email.indexOf('@') === -1 || email.indexOf('.') === -1 || email.startsWith('@') || email.endsWith('.')) {
                errorMessages.innerHTML = "Please enter a valid email.";
                event.preventDefault();
                return;
            }

            if (!password || password.length < 6) {
                errorMessages.innerHTML = "Password must be at least 6 characters.";
                event.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>
