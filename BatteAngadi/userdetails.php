<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile - Batte Angadi</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Verdana&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Verdana', 'Arial', sans-serif;
        }

        :root {
            --bg-dark: #0a001a;
            --bg-mid: #2b0b3d;
            --bg-darker: #2a0a3a;
            --accent: #B99BFF;
            --accent-strong: #6F3FBF;
            --light: #EDE7FF;
            --muted: rgba(185, 155, 255, 0.05);
        }

        body {
            background-color: var(--bg-dark);
            background-image: 
                linear-gradient(0deg, transparent 24%, var(--muted) 25%, var(--muted) 26%, transparent 27%, transparent 74%, var(--muted) 75%, var(--muted) 76%, transparent 77%, transparent),
                linear-gradient(90deg, transparent 24%, var(--muted) 25%, var(--muted) 26%, transparent 27%, transparent 74%, var(--muted) 75%, var(--muted) 76%, transparent 77%, transparent);
            background-size: 50px 50px;
            min-height: 100vh;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(180deg, var(--bg-mid) 0%, var(--bg-dark) 100%);
            padding: 18px 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.9), inset 0 1px 0px rgba(185, 155, 255, 0.4);
            border-bottom: 3px solid var(--accent);
            border-top: 2px solid var(--light);
        }

        .top-bar h1 {
            color: var(--accent);
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 2px;
            padding: 8px 20px;
            border: 2px solid var(--light);
            display: inline-block;
            font-style: normal;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            background: linear-gradient(135deg, rgba(185, 155, 255, 0.1) 0%, transparent 100%);
            font-family: 'Oswald', sans-serif;
        }

        .buttons-container {
            display: flex;
            gap: 12px;
        }

        #buttons {
            color: var(--bg-dark);
            text-decoration: none;
            padding: 10px 24px;
            border: 2px solid rgba(185,155,255,0.45);
            border-radius: 3px;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.2s ease;
            cursor: pointer;
            background: linear-gradient(180deg, var(--light) 0%, var(--accent) 100%);
            letter-spacing: 1px;
            text-transform: lowercase;
            box-shadow: inset 0 1px 0px rgba(255, 255, 255, 0.6), 0 2px 4px rgba(0, 0, 0, 0.6);
        }

        #buttons:hover {
            background: linear-gradient(180deg, #F8F4FF 0%, var(--light) 100%);
            transform: translateY(-1px);
            box-shadow: inset 0 1px 0px rgba(255, 255, 255, 0.8), 0 4px 8px rgba(0, 0, 0, 0.7);
        }

        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 20px;
        }

        .profile-card {
            background: linear-gradient(135deg, var(--bg-mid) 0%, var(--bg-darker) 100%);
            padding: 50px 40px;
            width: 100%;
            max-width: 500px;
            border: 2px solid rgba(185,155,255,0.45);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.8), inset 0 1px 0px rgba(185, 155, 255, 0.3);
            border-radius: 0px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-top: 1px solid var(--light);
        }

        .profile-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.9), inset 0 1px 0px rgba(185,155,255,0.4), 0 0 12px rgba(185,155,255,0.2);
        }

        .profile-card h2 {
            font-size: 28px;
            color: var(--light);
            margin-bottom: 30px;
            font-weight: 700;
            font-style: normal;
            text-align: center;
            border-bottom: 2px solid var(--accent);
            padding-bottom: 15px;
            text-transform: lowercase;
            letter-spacing: 1px;
            font-family: 'Oswald', sans-serif;
        }

        .profile-card h3 {
            font-size: 18px;
            color: var(--accent);
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
            text-transform: lowercase;
            font-family: 'Oswald', sans-serif;
        }

        .profile-info {
            margin-bottom: 20px;
            padding: 15px;
            background: linear-gradient(135deg, var(--bg-mid) 0%, var(--bg-darker) 100%);
            border-left: 3px solid var(--accent);
            border-radius: 0px;
            border: 1px solid rgba(50,20,70,0.35);
            border-left: 3px solid var(--accent);
        }

        .profile-info label {
            font-weight: 600;
            color: var(--light);
            display: block;
            font-size: 11px;
            text-transform: lowercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .profile-info p {
            color: var(--accent);
            font-size: 14px;
            word-break: break-word;
            font-weight: 500;
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            justify-content: center;
        }

        .btn {
            padding: 11px 24px;
            border: 2px solid rgba(120,80,200,0.2);
            border-top: 1px solid rgba(255,255,255,0.3);
            border-left: 1px solid rgba(255,255,255,0.3);
            border-radius: 3px;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            display: inline-block;
            letter-spacing: 0.5px;
            text-transform: lowercase;
            box-shadow: inset 0 1px 0px rgba(255, 255, 255, 0.6), 0 2px 4px rgba(0, 0, 0, 0.6);
        }

        .btn-logout {
            background: linear-gradient(180deg, var(--light) 0%, var(--accent) 100%);
            color: var(--bg-dark);
        }

        .btn-logout:hover {
            background: linear-gradient(180deg, #F3ECFF 0%, var(--accent) 100%);
            transform: translateY(-1px);
            box-shadow: inset 0 1px 0px rgba(255, 255, 255, 0.8), 0 4px 8px rgba(0, 0, 0, 0.7);
        }

        .btn-home {
            background: linear-gradient(180deg, var(--accent) 0%, #8a6eff 100%);
            color: var(--bg-dark);
        }

        .btn-home:hover {
            background: linear-gradient(180deg, #9b7bff 0%, #8a6eff 100%);
            transform: translateY(-1px);
            box-shadow: inset 0 1px 0px rgba(255, 255, 255, 0.8), 0 4px 8px rgba(0, 0, 0, 0.7);
        }

        .no-login {
            text-align: center;
            color: var(--accent);
            font-size: 14px;
            font-weight: 500;
        }

        .no-login a {
            color: var(--light);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .no-login a:hover {
            color: var(--light);
        }

        footer {
            background: linear-gradient(180deg, var(--bg-mid) 0%, var(--bg-dark) 100%);
            color: var(--accent);
            padding: 20px 40px;
            text-align: center;
            margin-top: 60px;
            border-top: 3px solid var(--accent);
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.8), inset 0 1px 0px rgba(185,155,255,0.3);
            font-weight: 600;
            text-transform: lowercase;
            letter-spacing: 0.5px;
        }

        footer a {
            color: var(--light);
            text-decoration: none;
            transition: color 0.2s ease;
            font-weight: 600;
        }

        footer a:hover {
            color: var(--light);
            text-shadow: 0 0 10px rgba(185,155,255,0.45);
        }
    </style>
</head>
<body>
    <header class="top-bar">
        <h1>Batte Angadi</h1>
        <div class="buttons-container">
            <a href="home.php" id="buttons">Home</a>
        </div>
    </header>

    <div class="profile-container">
        <?php
        if(isset($_SESSION["user"]) && $_SESSION["is_logged_in"]){
            echo "<div class='profile-card'>";
            echo "<h2>My Profile</h2>";
            echo "<h3>Welcome, " . htmlspecialchars($_SESSION["user"]) . "!</h3>";
            echo "<div class='profile-info'>";
            echo "<label>Username</label>";
            echo "<p>" . htmlspecialchars($_SESSION["user"]) . "</p>";
            echo "</div>";
            echo "<div class='profile-info'>";
            echo "<label>Phone Number</label>";
            echo "<p>" . htmlspecialchars($_SESSION["phno"]) . "</p>";
            echo "</div>";
            echo "<div class='button-group'>";
            echo "<a href='logout.php' class='btn btn-logout'>Logout</a>";
            echo "<a href='home.php' class='btn btn-home'>Back to Home</a>";
            echo "</div>";
            echo "</div>";
        }
        else{
            echo "<div class='profile-card'>";
            echo "<h2>Access Denied</h2>";
            echo "<div class='no-login'>";
            echo "<p>No user is logged in.</p><br>";
            echo "<a href='login.php'>Login here</a> or <a href='register.php'>Register</a>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>

    <footer>
        <p>&copy; 2026 Batte Angadi. All rights reserved.</p>
    </footer>
</body>
</html>