<?php
include 'db.php';
include 'session.php';

$booking_id = intval($_GET['id']);

$stmt = $conn->prepare("
    UPDATE bookings SET status = 'cancelled'
    WHERE booking_id = ? AND customer_id = ?
");
$stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);
$stmt->execute();

header("Location: myBookings.php");
exit();
?>