<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM admins WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid Login');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        body { background: #000; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; font-family: sans-serif; }
        .box { background: #111; padding: 40px; border-radius: 10px; border: 1px solid #222; width: 300px; text-align: center; }
        input { width: 100%; padding: 10px; margin: 10px 0; background: #222; border: 1px solid #333; color: white; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #00d4ff; border: none; font-weight: bold; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="box">
        <h2 style="color:#00d4ff">Admin Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
