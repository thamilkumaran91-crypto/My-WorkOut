<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$user = $_SESSION['user'];
$user_id = $user['id'];

// Fetch Events
$events = $conn->query("SELECT * FROM events");

// Fetch Fees
$fees = $conn->query("SELECT * FROM fees WHERE member_id = $user_id");

?>

<!DOCTYPE html>
<html>
<head>
    <title>My WorkOut - Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .header { background: #333; color: white; padding: 15px; text-align: center; }
        .container { padding: 20px; }
        .card { background: #eee; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        h3 { border-bottom: 2px solid #28a745; padding-bottom: 5px; }
        .logout { float: right; color: white; text-decoration: none; }
    </style>
</head>
<body>

<div class="header">
    Welcome, <?php echo $user['full_name']; ?> 
    <a href="logout.php" class="logout">Logout</a>
</div>

<div class="container">

    <div class="card">
        <h3>My Profile</h3>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Phone:</strong> <?php echo $user['phone']; ?></p>
        <p><strong>Membership Type:</strong> <?php echo $user['membership_type']; ?></p>
        <p><strong>Joined:</strong> <?php echo $user['join_date']; ?></p>
    </div>

    <div class="card">
        <h3>Upcoming Events</h3>
        <?php while($row = $events->fetch_assoc()): ?>
            <p><strong><?php echo $row['event_name']; ?></strong> (<?php echo $row['event_date']; ?>)<br>
            <?php echo $row['description']; ?></p>
        <?php endwhile; ?>
    </div>

    <div class="card">
        <h3>My Fees</h3>
        <?php if ($fees->num_rows > 0): ?>
            <?php while($row = $fees->fetch_assoc()): ?>
                <p>Amount: $<?php echo $row['amount']; ?> - Status: <?php echo $row['status']; ?></p>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No fee records found.</p>
        <?php endif; ?>
    </div>

    <div class="card">
        <h3>Attendance</h3>
        <p>Feature coming soon... (Link to attendance log)</p>
    </div>

</div>

</body>
</html>