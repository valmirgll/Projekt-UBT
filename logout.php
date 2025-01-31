<?php
session_start();
session_destroy();
header("Location: Krijimi i Login-form.php");
exit();
?>
