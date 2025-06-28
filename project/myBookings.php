<?php
include 'db.php';
include 'session.php';

$stmt = $conn->prepare("
    SELECT b.*, f.name as facility_name 
    FROM bookings b
    JOIN facilities f ON b.facility_id = f.facility_id
    WHERE b.customer_id = ?
    ORDER BY b.booking_date DESC
");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$bookings = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>My Bookings</h1>
    <table>
        <tr>
            <th>Facility</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $bookings->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['facility_name']) ?></td>
            <td><?= $row['booking_date'] ?></td>
            <td><?= $row['booking_time'] ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <?php if ($row['status'] == 'pending' || $row['status'] == 'confirmed'): ?>
                <a href="cancelBooking.php?id=<?= $row['booking_id'] ?>" 
                   onclick="return confirm('Cancel this booking?')">Cancel</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>