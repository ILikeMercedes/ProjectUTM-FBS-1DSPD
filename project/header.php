<?php
include 'session.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Facility Booking System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>STAR Facility Booking System</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="facility_list.php">Facilities</a></li>
                    <li><a href="myBookings.php">My Bookings</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>