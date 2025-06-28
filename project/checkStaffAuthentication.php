<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    $_SESSION['redirect_url'] = $_GET['redirect'] ?? 'admin.php';
    header("Location: staffLogin.php");
    exit();
}
$redirect = $_GET['redirect'] ?? 'admin.php';
header("Location: $redirect");
exit();
?>