<?php
include '../Condition/auth.php';
unset($_SESSION['user_id']);
header("Location: $Home");
exit();
?>