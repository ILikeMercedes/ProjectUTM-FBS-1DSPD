<?php
include 'db.php';
session_start();

if ($_SESSION['user_role'] != 'staff') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = intval($_POST['booking_id']);
    $status = in_array($_POST['status'], ['pending', 'confirmed', 'cancelled']) 
              ? $_POST['status'] 
              : 'pending';

    $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE booking_id = ?");
    $stmt->bind_param("si", $status, $booking_id);
    
    if ($stmt->execute()) {
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'staffManageBooking.php'));
        exit();
    } else {
        die("Update failed: " . $conn->error);
    }
} else {
    header("Location: staffManageBooking.php");
    exit();
}
?>