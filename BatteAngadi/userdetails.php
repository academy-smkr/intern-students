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

        body {
            background-color: #0a0a0a;
            background-image: 
                linear-gradient(0deg, transparent 24%, rgba(192, 192, 192, 0.05) 25%, rgba(192, 192, 192, 0.05) 26%, transparent 27%, transparent 74%, rgba(192, 192, 192, 0.05) 75%, rgba(192, 192, 192, 0.05) 76%, transparent 77%, transparent),
                linear-gradient(90deg, transparent 24%, rgba(192, 192, 192, 0.05) 25%, rgba(192, 192, 192, 0.05) 26%, transparent 27%, transparent 74%, rgba(192, 192, 192, 0.05) 75%, rgba(192, 192, 192, 0.05) 76%, transparent 77%, transparent);
            background-size: 50px 50px;
            min-height: 100vh;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(180deg, #2a2a2a 0%, #0a0a0a 100%);
            padding: 18px 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.9), inset 0 1px 0px rgba(192, 192, 192, 0.4);
            border-bottom: 3px solid #C0C0C0;
            border-top: 2px solid #E8E8E8;
        }

        .top-bar h1 {
            color: #C0C0C0;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 2px;
            padding: 8px 20px;
            border: 2px solid #E8E8E8;
            display: inline-block;
            font-style: normal;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            background: linear-gradient(135deg, rgba(192, 192, 192, 0.1) 0%, transparent 100%);
            font-family: 'Oswald', sans-serif;
        }

        .buttons-container {
            display: flex;
            gap: 12px;
        }

        #buttons {
            color: #000000;
            text-decoration: none;
            padding: 10px 24px;
            border: 2px solid #A8A8A8;
            border-radius: 3px;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.2s ease;
            cursor: pointer;
            background: linear-gradient(180deg, #E8E8E8 0%, #C0C0C0 100%);
            letter-spacing: 1px;
            text-transform: lowercase;
            box-shadow: inset 0 1px 0px rgba(255, 255, 255, 0.6), 0 2px 4px rgba(0, 0, 0, 0.6);
        }

        #buttons:hover {
            background: linear-gradient(180deg, #FFFFFF 0%, #D3D3D3 100%);
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
            background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
            padding: 50px 40px;
            width: 100%;
            max-width: 500px;
            border: 2px solid #A8A8A8;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.8), inset 0 1px 0px rgba(192, 192, 192, 0.3);
            border-radius: 0px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-top: 1px solid #E8E8E8;
        }

        .profile-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.9), inset 0 1px 0px rgba(192, 192, 192, 0.4), 0 0 12px rgba(192, 192, 192, 0.2);
        }

        .profile-card h2 {
            font-size: 28px;
            color: #E8E8E8;
            margin-bottom: 30px;
            font-weight: 700;
            font-style: normal;
            text-align: center;
            border-bottom: 2px solid #A8A8A8;
            padding-bottom: 15px;
            text-transform: lowercase;
            letter-spacing: 1px;
            font-family: 'Oswald', sans-serif;
        }

        .profile-card h3 {
            font-size: 18px;
            color: #C0C0C0;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
            text-transform: lowercase;
            font-family: 'Oswald', sans-serif;
        }

        .profile-info {
            margin-bottom: 20px;
            padding: 15px;
            background: linear-gradient(135deg, #1a1a1a 0%, #252525 100%);
            border-left: 3px solid #A8A8A8;
            border-radius: 0px;
            border: 1px solid #404040;
            border-left: 3px solid #C0C0C0;
        }

        .profile-info label {
            font-weight: 600;
            color: #E8E8E8;
            display: block;
            font-size: 11px;
            text-transform: lowercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .profile-info p {
            color: #C0C0C0;
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
            border: 2px solid #808080;
            border-top: 1px solid #FFFFFF;
            border-left: 1px solid #FFFFFF;
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
            background: linear-gradient(180deg, #C0C0C0 0%, #A8A8A8 100%);
            color: #000000;
        }

        .btn-logout:hover {
            background: linear-gradient(180deg, #D3D3D3 0%, #B8B8B8 100%);
            transform: translateY(-1px);
            box-shadow: inset 0 1px 0px rgba(255, 255, 255, 0.8), 0 4px 8px rgba(0, 0, 0, 0.7);
        }

        .btn-home {
            background: linear-gradient(180deg, #A8A8A8 0%, #909090 100%);
            color: #000000;
        }

        .btn-home:hover {
            background: linear-gradient(180deg, #B8B8B8 0%, #A0A0A0 100%);
            transform: translateY(-1px);
            box-shadow: inset 0 1px 0px rgba(255, 255, 255, 0.8), 0 4px 8px rgba(0, 0, 0, 0.7);
        }

        .no-login {
            text-align: center;
            color: #C0C0C0;
            font-size: 14px;
            font-weight: 500;
        }

        .no-login a {
            color: #E8E8E8;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .no-login a:hover {
            color: #FFFFFF;
        }

        footer {
            background: linear-gradient(180deg, #2a2a2a 0%, #0a0a0a 100%);
            color: #C0C0C0;
            padding: 20px 40px;
            text-align: center;
            margin-top: 60px;
            border-top: 3px solid #C0C0C0;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.8), inset 0 1px 0px rgba(192, 192, 192, 0.3);
            font-weight: 600;
            text-transform: lowercase;
            letter-spacing: 0.5px;
        }

        footer a {
            color: #E8E8E8;
            text-decoration: none;
            transition: color 0.2s ease;
            font-weight: 600;
        }

        footer a:hover {
            color: #FFFFFF;
            text-shadow: 0 0 8px rgba(192, 192, 192, 0.5);
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