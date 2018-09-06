<?php
session_start();
$_SESSION['u'];
unset($_SESSION['u']);
session_destroy();
setcookie("inicio","",time()+0);
header('Location: ../index.php');
?>