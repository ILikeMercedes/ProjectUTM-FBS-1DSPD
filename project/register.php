<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$phone = $_POST['phoneN'];
	$address = $_POST['address'];

    $stmt = $conn->prepare("INSERT INTO customers (full_name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);
    
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $conn->insert_id;
        header("Location: myBookings.php");
        exit();
    } else {
        $error = "Email already exists!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>Customer registration</h1>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        Full Name: <input type="text" name="full_name" required><br>
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
		Phone number: <input type="number" name="phoneN" required><br>
		Address: <input type="text" name="address" required><br>
        <input type="submit" value="Register">
		<a href="login.php">Already have an account? Login</a>
	</form>
	<a href="index.php">Return to home</a>
</body>
</html>