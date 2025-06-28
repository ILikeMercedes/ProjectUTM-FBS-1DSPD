<?php
include 'db.php';
include 'session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $facility_id = intval($_POST['facility_id']);
    $date = $conn->real_escape_string($_POST['date']);
    $time = $conn->real_escape_string($_POST['time']);

    $stmt = $conn->prepare("
        INSERT INTO bookings (customer_id, facility_id, booking_date, booking_time, status)
        VALUES (?, ?, ?, ?, 'Pending')
    ");
    $stmt->bind_param("iiss", $_SESSION['user_id'], $facility_id, $date, $time);
    $stmt->execute();
    header("Location: myBookings.php");
    exit();
}

$facilities = $conn->query("SELECT * FROM facilities WHERE status = 'Available'");
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
    <title>Book Facility</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function checkAvailability() {
        var facility = $('#facility').val();
        var date = $('#date').val();
        
        if (!facility || !date) return;
        
        $.get('available.php', {
            facility_id: facility,
            date: date
        })
        .done(function(data) {
            $('#time_slot').empty();
            if (data.available_times && data.available_times.length > 0) {
                data.available_times.forEach(function(time) {
                    $('#time_slot').append('<option value="' + time + '">' + time + '</option>');
                });
            } else {
                $('#time_slot').append('<option value="">No available slots</option>');
            }
        })
        .fail(function() {
            $('#time_slot').empty().append('<option value="">Error loading slots</option>');
        });
    }
    
    $(document).ready(function() {
        $('#facility, #date').change(checkAvailability);
    });
</script>
</head>
<body>
    <h1>Book a Facility</h1>
    <form method="POST">
        <label>Facility:
            <select id="facility" name="facility_id" required>
                <?php while ($facility = $facilities->fetch_assoc()): ?>
                <option value="<?= $facility['facility_id'] ?>">
                    <?= htmlspecialchars($facility['name']) ?>
                </option>
                <?php endwhile; ?>
            </select>
        </label><br>
        
        <label>Date:
            <input type="date" id="date" name="date" required 
                   min="<?= date('Y-m-d') ?>" onchange="checkAvailability()">
        </label><br>
        
        <label>Booking time:
            <input type="time" id="time_slot" name="time" required>
        </label><br>
        
        <button type="submit">Book Now</button>
    </form>
	<a href="index.php">Return to home</a>
</body>
</html>