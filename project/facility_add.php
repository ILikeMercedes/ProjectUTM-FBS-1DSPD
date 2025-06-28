<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: staffLogin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO facilities (name, description, location, capacity, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", 
        $_POST['name'],
        $_POST['description'],
        $_POST['location'],
        $_POST['capacity'],
        $_POST['status']
    );
    $stmt->execute();
    header("Location: facility_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="POST">
        Name: <input type="text" name="name" required><br>
        Description: <textarea name="description" rows="5" cols="50"></textarea><br>
        Location: <input type="text" name="location" required><br>
        Capacity: <input type="number" name="capacity" required><br>
        Status: 
        <select name="status" required>
            <option value="Available">Available</option>
            <option value="Unavailable">Unavailable</option>
            <option value="Maintenance">Maintenance</option>
        </select><br>
        <input type="submit" value="Add Facility">
    </form>
<div class="form-actions">
    <a href="<?= $_SERVER['HTTP_REFERER'] ?? 'index.php' ?>" class="button">Back</a>
</div>
</body>
</html>

