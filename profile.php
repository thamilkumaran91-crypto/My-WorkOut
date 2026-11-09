<?php
session_start();
include 'db.php';

// 1. Check Login
if (!isset($_SESSION['user'])) {
    header("Location: index.php"); // Redirect if not logged in
    exit();
}

$user_id = $_SESSION['user']['id'];
$message = "";

// 2. HANDLE IMAGE UPLOAD
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_image"])) {
    
    $target_dir = ""; // Current folder
    $file_name = basename($_FILES["profile_image"]["name"]);
    $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Create unique name to prevent overwriting (e.g., profile_5_89230.jpg)
    $new_file_name = "profile_" . $user_id . "_" . time() . "." . $imageFileType;
    $target_file = $target_dir . $new_file_name;

    // Validate image
    $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
    
    if($check !== false) {
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            
            // Update Database
            $conn->query("UPDATE members SET photo='$new_file_name' WHERE id=$user_id");
            
            // Update Session
            $_SESSION['user']['photo'] = $new_file_name;
            
            // Refresh to see change
            header("Location: profile.php"); 
            exit();
        } else {
            $message = "Error uploading file.";
        }
    } else {
        $message = "File is not an image.";
    }
}

// 3. FETCH MEMBER DETAILS (Including Trainer Name)
$sql = "SELECT members.*, trainers.trainer_name 
        FROM members 
        LEFT JOIN trainers ON members.trainer_id = trainers.id 
        WHERE members.id = $user_id";

$result = $conn->query($sql);
$profile = $result->fetch_assoc();

// Default values if NULL
$trainer_name = $profile['trainer_name'] ?? "Not Assigned";
$gender = $profile['gender'] ?? "Not Specified";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - My WorkOut</title>
    <style>
        body {
            background-color: #0d0d0d;
            color: white;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        .profile-card {
            background-color: #1a1a1a;
            width: 400px;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 0 20px rgba(204, 255, 0, 0.2);
            border: 1px solid #333;
            position: relative;
        }

        /* Profile Image */
        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #CCFF00;
            margin-bottom: 15px;
        }

        /* Upload Button (Hidden Input Trick) */
        .upload-wrapper {
            margin-bottom: 20px;
        }
        
        .btn-upload {
            background: #333;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            border: 1px solid #555;
            cursor: pointer;
            font-size: 12px;
        }
        
        .btn-upload:hover { background: #CCFF00; color: black; }

        input[type="file"] {
            display: none; /* Hide the ugly default file button */
        }

        /* Text Styling */
        h2 { margin: 10px 0; text-transform: uppercase; font-size: 26px; letter-spacing: 1px; }
        
        p { color: #aaa; margin: 8px 0; font-size: 16px; }
        
        .highlight { color: #CCFF00; font-weight: bold; }

        /* Back Button */
        .btn-back {
            display: inline-block; margin-top: 30px; padding: 10px 30px;
            background-color: transparent; color: white; border: 2px solid #CCFF00;
            text-decoration: none; font-weight: bold; border-radius: 25px; transition: 0.3s;
        }
        .btn-back:hover { background-color: #CCFF00; color: black; }
        
        /* Stats Row */
        .stats {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            border-top: 1px solid #333;
            padding-top: 20px;
        }
        .stat-box span { display: block; font-size: 20px; font-weight: bold; }
        .stat-box small { color: #777; font-size: 12px; text-transform: uppercase; }

        .error-msg { color: red; font-size: 12px; }

    </style>
</head>
<body>

    <div class="profile-card">
        
        <?php if($message): ?>
            <p class="error-msg"><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            
            <img src="<?php echo $profile['photo']; ?>" class="profile-img">
            
            <div class="upload-wrapper">
                <label for="file-upload" class="btn-upload">
                    Change Photo
                </label>
                <input id="file-upload" type="file" name="profile_image" onchange="this.form.submit()">
            </div>

        </form>

        <h2><?php echo $profile['full_name']; ?></h2>
        
        <p>Gender: <span class="highlight"><?php echo $gender; ?></span></p> <p>Membership: <span class="highlight"><?php echo $profile['membership_type']; ?></span></p>
        <p>Trainer: <span class="highlight"><?php echo $trainer_name; ?></span></p>
        <p>Member Since: <?php echo date("M d, Y", strtotime($profile['join_date'])); ?></p>

        <div class="stats">
            <div class="stat-box"><span>12</span><small>Workouts</small></div>
            <div class="stat-box"><span>Active</span><small>Status</small></div>
            <div class="stat-box"><span><?php echo $profile['membership_type']; ?></span><small>Plan</small></div>
        </div>

        <a href="index.php" class="btn-back">Back to Home</a>
    </div>

</body>
</html>