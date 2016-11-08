<?php
session_start();
unset($_SESSION['username']);
$link = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'index.php';
header("Location: ". $link);
?>