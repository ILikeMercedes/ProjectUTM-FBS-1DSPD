<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$booking_id = intval($_GET['id']);
$query = $_SESSION['user_role'] == 'staff'
    ? "SELECT b.*, c.name as customer_name, f.name as facility_name 
       FROM bookings b
       JOIN customers c ON b.customer_id = c.customer_id
       JOIN facilities f ON b.facility_id = f.facility_id
       WHERE b.booking_id = ?"
    : "SELECT b.*, f.name as facility_name 
       FROM bookings b
       JOIN facilities f ON b.facility_id = f.facility_id
       WHERE b.booking_id = ? AND b.customer_id = ?";

$stmt = $conn->prepare($query);
$_SESSION['user_role'] == 'staff'
    ? $stmt->bind_param("i", $booking_id)
    : $stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<body>
    <h1>Booking Details</h1>
    <?php if ($booking): ?>
    <p>Facility: <?= htmlspecialchars($booking['facility_name']) ?></p>
    <p>Date: <?= $booking['booking_date'] ?></p>
    <p>Time: <?= $booking['booking_time'] ?></p>
    <p>Status: <?= $booking['status'] ?></p>
    <?php if ($_SESSION['user_role'] == 'staff'): ?>
    <p>Customer: <?= htmlspecialchars($booking['customer_name']) ?></p>
    <?php endif; ?>
    <?php else: ?>
    <p>Booking not found or access denied</p>
    <?php endif; ?>
    <a href="<?= $_SESSION['user_role'] == 'staff' ? 'staffManageBooking.php' : 'myBookings.php' ?>">Back</a>
</body>
</html>