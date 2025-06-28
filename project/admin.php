<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Admin Dashboard</h1>
  <ul>
    <li><a href="facility_add.php">Add Facility</a></li>
    <li><a href="facility_list.php">View Facilities</a></li>
    <li><a href="add_customer.php">Register Customer</a></li>
    <li><a href="facility_edit.php">Manage Bookings</a></li>
	<li><a href="logout.php">Log out</a></li>
  </ul>
</body>
</html>
<?php 
include 'session.php';

if ($_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
