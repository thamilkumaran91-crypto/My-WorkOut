<?php
session_start();
include 'db.php';

$message = "";

// --- 1. HANDLE MANUAL REGISTRATION ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup_manual'])) {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender']; // <--- NEW FIELD
    $pass = $_POST['password'];
    $plan = $_POST['membership_type'];

    // Check if email already exists
    $check = $conn->query("SELECT * FROM members WHERE email='$email'");
    if ($check->num_rows > 0) {
        $message = "Error: Email already registered!";
    } else {
        // Insert new user WITH GENDER
        $sql = "INSERT INTO members (full_name, email, phone, gender, password, membership_type, join_date, photo) 
                VALUES ('$name', '$email', '$phone', '$gender', '$pass', '$plan', CURDATE(), 'default.jpg')";
        
        if ($conn->query($sql) === TRUE) {
            // Log them in immediately
            $_SESSION['user'] = $conn->query("SELECT * FROM members WHERE email='$email'")->fetch_assoc();
            header("Location: index.php");
            exit();
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}

// --- 2. HANDLE "SIMULATED" SIGN UP ---
if (isset($_GET['sim_signup'])) {
    $type = $_GET['sim_signup'];
    $rand = rand(1000, 9999);
    
    $name = "$type User $rand";
    $email = strtolower($type) . "_user_$rand@example.com";
    $phone = "000-000-$rand";
    $pass = "password";
    
    // Default gender for simulation
    $sql = "INSERT INTO members (full_name, email, phone, gender, password, membership_type, join_date, photo) 
            VALUES ('$name', '$email', '$phone', 'Other', '$pass', 'Silver', CURDATE(), 'default.jpg')";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION['user'] = $conn->query("SELECT * FROM members WHERE email='$email'")->fetch_assoc();
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Join Fitnation - Sign Up</title>
    <style>
        body { background-color: #0d0d0d; color: white; font-family: 'Arial', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .register-container { background-color: #1a1a1a; padding: 40px; border-radius: 15px; width: 400px; box-shadow: 0 0 20px rgba(0,0,0,0.5); border: 1px solid #333; }
        h2 { color: #CCFF00; text-align: center; text-transform: uppercase; margin-bottom: 20px; }
        input, select { width: 100%; padding: 12px; margin: 8px 0; background-color: #333; border: 1px solid #444; color: white; border-radius: 5px; box-sizing: border-box; }
        .btn-register { width: 100%; padding: 12px; background-color: #CCFF00; color: black; font-weight: bold; border: none; border-radius: 5px; cursor: pointer; margin-top: 15px; text-transform: uppercase; }
        .btn-register:hover { background-color: white; }
        .divider { text-align: center; margin: 20px 0; color: #666; font-size: 12px; }
        .social-btn { width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; display: flex; align-items: center; justify-content: center; gap: 10px; text-decoration: none; font-size: 14px; }
        .google { background-color: white; color: black; }
        .apple { background-color: black; color: white; border: 1px solid #333; }
        .error { color: #ff4d4d; text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>Become a Member</h2>
        <?php if($message): ?><p class="error"><?php echo $message; ?></p><?php endif; ?>

        <form method="POST">
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            
            <select name="gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <select name="membership_type">
                <option value="Silver">Silver Plan</option>
                <option value="Gold">Gold Plan</option>
                <option value="Platinum">Platinum Plan</option>
            </select>
            <input type="password" name="password" placeholder="Create Password" required>
            
            <button type="submit" name="signup_manual" class="btn-register">Join Now</button>
        </form>

        <div class="divider">- OR JOIN WITH -</div>
        <a href="register.php?sim_signup=Google" class="social-btn google"><span>G</span> Join with Google</a>
        <a href="register.php?sim_signup=Apple" class="social-btn apple"><span></span> Join with Apple ID</a>
    </div>

</body>
</html>