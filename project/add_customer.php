<?php
include 'db.php';
session_start();

if ($_SESSION['user_role'] !== 'staff') {
    header("Location: register.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO customers (name, email, phone, password) VALUES (?, ?, ?, ?)");
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt->bind_param("ssss", $_POST['name'], $_POST['email'], $_POST['phone'], $password);
    $stmt->execute();
    header("Location: customerList.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<body>
    <form method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone">
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Add Customer</button>
    </form>
</body>
</html>