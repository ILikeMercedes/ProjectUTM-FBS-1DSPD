<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['user_role'] == 'admin') {
    $sql = "SELECT b.*, c.full_name as customer_name, f.name as facility_name
            FROM bookings b
            JOIN customers c ON b.customer_id = c.customer_id
            JOIN facilities f ON b.facility_id = f.facility_id
            ORDER BY b.booking_date DESC, b.booking_time DESC";
} else {
    $sql = "SELECT b.*, c.full_name as customer_name, f.name as facility_name
            FROM bookings b
            JOIN customers c ON b.customer_id = c.customer_id
            JOIN facilities f ON b.facility_id = f.facility_id
            WHERE b.status = 'Confirmed'
            ORDER BY b.booking_date DESC, b.booking_time DESC";
}

$bookings = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Bookings</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Manage Bookings</h1>
    
    <?php if ($bookings->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Facility</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <?php if ($_SESSION['user_role'] == 'admin'): ?>
                <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($booking = $bookings->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($booking['booking_id']) ?></td>
                <td><?= htmlspecialchars($booking['customer_name']) ?></td>
                <td><?= htmlspecialchars($booking['facility_name']) ?></td>
                <td><?= htmlspecialchars($booking['booking_date']) ?></td>
                <td><?= htmlspecialchars($booking['booking_time']) ?></td>
                <td><?= htmlspecialchars($booking['status']) ?></td>
                <?php if ($_SESSION['user_role'] == 'admin'): ?>
                <td>
                    <a href="facility_edit.php?id=<?= $booking['booking_id'] ?>">Edit</a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>No bookings found.</p>
    <?php endif; ?>
</body>
</html>