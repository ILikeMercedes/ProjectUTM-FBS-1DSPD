<?php
include 'db.php';
session_start();

$search = $_GET['search'] ?? '';
$stmt = $conn->prepare("SELECT * FROM facilities WHERE name LIKE ?");
$searchParam = "%$search%";
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="GET">
        <input type="text" name="search" placeholder="Search facilities...">
        <input type="submit" value="Search">
    </form>
</div>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Location</th>
            <th>Capacity</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['facility_id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><?= htmlspecialchars($row['capacity']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td>
                <a href="facility_edit.php?id=<?= $row['facility_id'] ?>">Edit</a> |
                <a href="facility_delete.php?id=<?= $row['facility_id'] ?>" onclick="return confirm('Delete this facility?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="checkStaffAuthentication.php?redirect=facility_add.php">Add New Facility</a>
	<div class="form-actions">
    <a href="<?= $_SERVER['HTTP_REFERER'] ?? 'index.php' ?>" class="button">Back</a><br>
	<a href="index.php">Return to home</a>
</body>
</html>


