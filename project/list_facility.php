<?php
include 'db.php';

$sql = "SELECT * FROM facilities";
$result = $conn->query($sql);

$facilities = [];

while ($row = $result->fetch_assoc()) {
    $facilities[] = $row;
}

header('Content-Type: application/json');
echo json_encode($facilities);
?>