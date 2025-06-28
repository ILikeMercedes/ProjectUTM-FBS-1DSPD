<?php
include 'db.php';
session_start();

if ($_SESSION['user_role'] != 'staff') {
    header("Location: login.php");
    exit();
}

$facility_id = $_GET['id'];
$conn->begin_transaction();

try {
    $stmt = $conn->prepare("DELETE FROM bookings WHERE facility_id = ?");
    $stmt->bind_param("i", $facility_id);
    $stmt->execute();
    
    $stmt = $conn->prepare("DELETE FROM facilities WHERE facility_id = ?");
    $stmt->bind_param("i", $facility_id);
    $stmt->execute();
    
    $conn->commit();
    header("Location: facility_list.php");
} catch (Exception $e) {
    $conn->rollback();
    die("Error deleting facility: " . $e->getMessage());
}
?>