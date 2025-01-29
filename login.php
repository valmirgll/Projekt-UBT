<?php
include_once "user.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User();
    $result = $user->login($_POST['email'], $_POST['password']);
    
    if ($result === "admin") {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit;
    } elseif ($result === "user") {
        $_SESSION['user_logged_in'] = true;
        header("Location: user.php");
        exit;
    } else {
        $login_error = "Invalid login credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="POST">
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Password">
        <button type="submit">Login</button>
    </form>
    <?php if (isset($login_error)) echo "<p>$login_error</p>"; ?>
</body>
</html>
