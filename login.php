<?php
include_once "user.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new User();
    $result = $user->login($_POST['email'], $_POST['password']);
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
    <?php if (isset($result)) echo "<p>$result</p>"; ?>
</body>
</html>