<?php
include 'db.php';
session_start();

if ($_SESSION['user_role'] !== 'staff') {
    header("Location: login.php");
    exit();
}

$search = $_GET['q'] ?? '';
$stmt = $conn->prepare("SELECT * FROM customers WHERE name LIKE ?");
$searchParam = "%$search%";
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<body>
    <form method="GET">
        <input type="text" name="q" placeholder="Search customers...">
        <button type="submit">Search</button>
    </form>
    <table>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
