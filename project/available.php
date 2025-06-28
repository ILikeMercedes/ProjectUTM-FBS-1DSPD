<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$facility_id = intval($_GET['facility_id']);
$date = $conn->real_escape_string($_GET['date']); // YYYY-MM-DD

$stmt = $conn->prepare("
    SELECT booking_time 
    FROM bookings 
    WHERE facility_id = ? 
    AND booking_date = ? 
    AND status != 'Cancelled'
");
$stmt->bind_param("is", $facility_id, $date);
$stmt->execute();
$booked = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$all_slots = [];
for ($hour = 9; $hour <= 21; $hour++) {
    $all_slots[] = sprintf("%02d:00", $hour);
    $all_slots[] = sprintf("%02d:30", $hour);
}

$booked_slots = array_column($booked, 'booking_time');
$available = array_diff($all_slots, $booked_slots);

header('Content-Type: application/json');
echo json_encode([
    'facility_id' => $facility_id,
    'date' => $date,
    'available_times' => array_values($available)
]);
?>