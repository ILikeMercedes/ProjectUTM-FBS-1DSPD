<!DOCTYPE HTML>
<html>
    <head>
        <title>Staff Login</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Staff Login</h1>
        <?php if (isset($error)) { echo "<p style='color:red'>$error</p>"; } ?>
        <form method="POST">
            <label>Staff ID:</label>
            <input type="text" name="staffId" required><br>
            
            <label>Password:</label>
            <input type="password" name="password" required><br>
            
            <input type="submit" value="Login">
        </form>
		<a href="index.php">Return to home</a>
    </body>
</html>
<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staffId = intval($_POST['staffId']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT staff_id, name, password, role FROM staff WHERE staff_id = ?");
    $stmt->bind_param("i", $staffId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $staff = $result->fetch_assoc();
        
        if ($password === $staff['password']) {
    $_SESSION['user_id'] = $staff['staff_id'];
    $_SESSION['user_name'] = $staff['name'];
    $_SESSION['user_role'] = $staff['role'];
    
    $redirect = $_SESSION['redirect_url'] ?? 'admin.php';
    unset($_SESSION['redirect_url']);
    header("Location: $redirect");
    exit();
}
    }
    
    $error = "Invalid Staff ID or Password!";
}
?>