<?php
include 'db.php';
session_start();

if ($_SESSION['user_role'] != 'staff') {
    header("Location: login.php");
    exit();
}

$search = $_GET['search'] ?? '';
$stmt = $conn->prepare("SELECT * FROM customers WHERE name LIKE ?");
$searchParam = "%$search%";
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Customer List</h1>
    <form method="GET">
        <input type="text" name="search" placeholder="Search customers...">
        <input type="submit" value="Search">
    </form>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['customer_id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td>
                <a href="updateCustomer.php?id=<?= $row['customer_id'] ?>">Edit</a> |
                <a href="deleteCustomer.php?id=<?= $row['customer_id'] ?>" 
                   onclick="return confirm('Delete this customer?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>