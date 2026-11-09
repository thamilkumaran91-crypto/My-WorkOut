<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My WorkOut | Premium Fitness Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-cyan: #00d4ff;
            --dark-bg: #000000;
            --panel-bg: #1a1a1a;
            --text-gray: #aaaaaa;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--dark-bg); color: white; overflow-x: hidden; }

        /* NAVBAR */
        .navbar { 
            display: flex; justify-content: space-between; align-items: center; 
            padding: 25px 6%; position: fixed; width: 100%; top: 0; 
            background: linear-gradient(to bottom, rgba(0,0,0,0.9), transparent); 
            z-index: 1000; transition: 0.3s;
        }
        .logo { font-size: 26px; font-weight: 900; color: var(--primary-cyan); text-transform: uppercase; letter-spacing: -1px; text-decoration: none; }
        
        .nav-right { display: flex; align-items: center; gap: 25px; }
        .btn-nav { 
            padding: 10px 25px; border: 2px solid var(--primary-cyan); border-radius: 50px; 
            color: var(--primary-cyan); font-weight: 700; text-decoration: none; 
            text-transform: uppercase; font-size: 14px; transition: 0.3s;
        }
        .btn-nav:hover { background: var(--primary-cyan); color: black; box-shadow: 0 0 15px var(--primary-cyan); }
        .menu-btn { font-size: 28px; cursor: pointer; color: white; transition: 0.3s; }
        .menu-btn:hover { color: var(--primary-cyan); }

        /* HERO SECTION */
        .hero { 
            height: 100vh; width: 100%; display: flex; align-items: center; 
            padding: 0 8%; background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
            url('https://images.unsplash.com/photo-1540497077202-7c8a3999166f?q=80&w=2070&auto=format&fit=crop'); 
            background-size: cover; background-position: center; 
        }
        
        .hero-content { max-width: 700px; }
        .hero h1 { font-size: 75px; font-weight: 900; line-height: 0.95; margin-bottom: 25px; text-transform: uppercase; }
        .hero h1 span { color: var(--primary-cyan); }
        .hero p { color: var(--text-gray); font-size: 18px; margin-bottom: 35px; line-height: 1.6; max-width: 500px; }

        /* PORTAL PANEL */
        .portal-container { 
            background: var(--panel-bg); padding: 40px; border-radius: 20px; 
            border-left: 6px solid var(--primary-cyan); width: 350px; 
            box-shadow: 0 25px 50px rgba(0,0,0,0.6); position: relative; 
            margin-left: auto; /* Pushes it to the right side */
        }
        .portal-container h3 { font-size: 22px; margin-bottom: 10px; font-weight: 700; }
        .portal-container p { font-size: 14px; color: var(--text-gray); margin-bottom: 25px; }

        .portal-btn { 
            display: flex; align-items: center; justify-content: center; width: 100%; 
            padding: 16px; margin-bottom: 12px; border-radius: 10px; 
            text-decoration: none; font-weight: 700; transition: 0.3s; 
        }
        .btn-member { background: #333; color: white; }
        .btn-member:hover { background: var(--primary-cyan); color: black; }
        .btn-admin { background: transparent; border: 1px solid #444; color: var(--text-gray); }
        .btn-admin:hover { border-color: var(--primary-cyan); color: var(--primary-cyan); }

        /* SIDEBAR */
        .sidebar { 
            position: fixed; top: 0; right: -350px; width: 350px; height: 100%; 
            background: #0a0a0a; z-index: 2000; transition: 0.5s cubic-bezier(0.77,0.2,0.05,1.0); 
            padding: 60px 40px; border-left: 1px solid #222;
        }
        .sidebar.active { right: 0; }
        .close-btn { position: absolute; top: 30px; right: 30px; font-size: 35px; cursor: pointer; color: var(--text-gray); }
        .sidebar-links a { 
            display: block; color: white; text-decoration: none; font-size: 24px; 
            font-weight: 700; margin-bottom: 25px; transition: 0.3s; text-transform: uppercase;
        }
        .sidebar-links a:hover { color: var(--primary-cyan); transform: translateX(10px); }

        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); display: none; z-index: 1500; backdrop-filter: blur(5px); }
        .overlay.active { display: block; }

        @media (max-width: 900px) {
            .hero { flex-direction: column; justify-content: center; text-align: center; padding-top: 100px; }
            .hero h1 { font-size: 50px; }
            .portal-container { margin: 40px auto 0; width: 100%; }
        }
    </style>
</head>
<body>

    <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

    <div class="sidebar" id="sidebar">
        <div class="close-btn" onclick="toggleMenu()">&times;</div>
        <div class="sidebar-links">
            <a href="index.php">Home</a>
            <a href="shop.php">Shop Gear</a>
            <a href="member_login.php">Member Access</a>
            <a href="login.php">Admin Staff</a>
            <a href="#">Contact</a>
        </div>
    </div>

    <nav class="navbar">
        <a href="index.php" class="logo">My WorkOut</a>
        <div class="nav-right">
            <a href="member_login.php" class="btn-nav">Sign In</a>
            <div class="menu-btn" onclick="toggleMenu()">&#9776;</div>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <h1>Unleash Your <br> <span>Inner Athlete</span></h1>
            <p>Experience the ultimate fitness management system. Track your progress, manage your membership, and hit your goals at <strong>My WorkOut</strong>.</p>
        </div>

        <div class="portal-container">
            <h3>Portal Access</h3>
            <p>Welcome back! Select your login method to continue your journey.</p>
            
            <a href="member_login.php" class="portal-btn btn-member">Member Entrance ➜</a>
            <a href="login.php" class="portal-btn btn-admin">Admin Dashboard</a>
        </div>
    </section>

    <script>
        function toggleMenu() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('overlay').classList.toggle('active');
        }
    </script>
</body>
</html>