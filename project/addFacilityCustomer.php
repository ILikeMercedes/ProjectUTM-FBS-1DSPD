<?php
include 'db.php';
session_start();

if(empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$facility_id = intval($_GET['id']); // Force to integer

$result = $conn->query("
    SELECT c.name, c.email, b.booking_date, b.booking_time
    FROM bookings b
    JOIN customers c ON b.customer_id = c.customer_id
    WHERE b.facility_id = $facility_id
");

echo "<h2>Bookings for Facility #$facility_id</h2>";
echo "<table border='1'><tr><th>Name</th><th>Email</th><th>Date</th><th>Time</th></tr>";

while($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['booking_date']}</td>
        <td>{$row['booking_time']}</td>
    </tr>";
}

echo "</table>";
?>