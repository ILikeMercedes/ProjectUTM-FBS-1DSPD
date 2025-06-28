<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_GET['id'] ?? $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM customers WHERE customer_id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$customer = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    
    $stmt = $conn->prepare("UPDATE customers SET name=?, email=?, phone=? WHERE customer_id=?");
    $stmt->bind_param("sssi", $name, $email, $phone, $customer_id);
    
    if ($stmt->execute()) {
        $success = "Profile updated successfully!";
    } else {
        $error = "Update failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Profile</h1>
    <?php 
    if (isset($success)) echo "<p style='color:green'>$success</p>";
    if (isset($error)) echo "<p style='color:red'>$error</p>"; 
    ?>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($customer['name']) ?>" required><br>
        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>" required><br>
        <label>Phone:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone']) ?>"><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>
