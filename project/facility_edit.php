<?php
include 'db.php';
session_start();

// Get facility ID from URL
$facility_id = intval($_GET['id'] ?? 0);

// Fetch facility data
$facility = [];
$stmt = $conn->prepare("SELECT * FROM facilities WHERE facility_id = ?");
$stmt->bind_param("i", $facility_id);
$stmt->execute();
$result = $stmt->get_result();
$facility = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("UPDATE facilities SET name=?, description=?, location=?, capacity=?, status=? WHERE facility_id=?");
    $stmt->bind_param("sssisi", 
        $_POST['name'],
        $_POST['description'],
        $_POST['location'],
        $_POST['capacity'],
        $_POST['status'],
        $facility_id
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
    <title>Edit Facility</title>
    <style>
        form { max-width: 500px; margin: 20px auto; }
        input, textarea, select { width: 100%; padding: 8px; margin: 5px 0; }
        button { padding: 8px 15px; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Edit Facility</h1>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($facility['name'] ?? '') ?>" required>
        
        <label>Description:</label>
        <textarea name="description"><?= htmlspecialchars($facility['description'] ?? '') ?></textarea>
        
        <label>Location:</label>
        <input type="text" name="location" value="<?= htmlspecialchars($facility['location'] ?? '') ?>" required>
        
        <label>Capacity:</label>
        <input type="number" name="capacity" value="<?= htmlspecialchars($facility['capacity'] ?? '') ?>" required>
        
        <label>Status:</label>
        <select name="status" required>
            <option value="Available" <?= ($facility['status'] ?? '') == 'Available' ? 'selected' : '' ?>>Available</option>
            <option value="Unavailable" <?= ($facility['status'] ?? '') == 'Unavailable' ? 'selected' : '' ?>>Unavailable</option>
            <option value="Maintenance" <?= ($facility['status'] ?? '') == 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
        </select>
        
        <button type="submit">Update</button>
        <a href="facility_list.php">Cancel</a>
    </form>
</body>
</html>