<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'staff') {
    header("Location: login.php");
    exit();
}

$stmt = $conn->prepare("
    SELECT b.*, f.name as facility_name 
    FROM bookings b
    JOIN facilities f ON b.facility_id = f.facility_id
    WHERE b.customer_id = ?
");
$stmt->bind_param("i", $_GET['customer_id']);
$stmt->execute();
$bookings = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Bookings</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
    </style>
</head>
<body>
    <h1>Bookings for Customer #<?= htmlspecialchars($_GET['customer_id']) ?></h1>
    <table>
        <tr>
            <th>Facility</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $bookings->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['facility_name']) ?></td>
            <td><?= $row['booking_date'] ?></td>
            <td><?= $row['booking_time'] ?></td>
            <td><?= $row['status'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="customerList.php">Back to Customers</a>
</body>
</html>