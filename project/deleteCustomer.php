<?php
include 'db.php';
session_start();

if ($_SESSION['user_role'] != 'staff') {
    header("Location: login.php");
    exit();
}

$customer_id = $_GET['id'];
if (!is_numeric($customer_id)) die("Invalid customer ID");

$conn->begin_transaction();
try {
    $stmt = $conn->prepare("DELETE FROM bookings WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    
    $stmt = $conn->prepare("DELETE FROM customers WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    
    $conn->commit();
    header("Location: customerList.php");
} catch (Exception $e) {
    $conn->rollback();
    die("Error: " . $e->getMessage());
}
?>