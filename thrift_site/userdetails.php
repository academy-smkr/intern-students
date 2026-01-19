<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile - Shoply</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Georgia', 'Courier New', serif;
        }

        body {
            background-color: #e8dcc8;
            background-image: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 35px,
                rgba(0,0,0,.05) 35px,
                rgba(0,0,0,.05) 70px
            );
            min-height: 100vh;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #6b5b4c 0%, #8b7765 100%);
            padding: 18px 40px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border-bottom: 4px solid #4a3f36;
        }

        .top-bar h1 {
            color: #f5e6d3;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 3px;
            padding: 8px 20px;
            border: 3px solid #f5e6d3;
            display: inline-block;
            font-style: italic;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .buttons-container {
            display: flex;
            gap: 12px;
        }

        #buttons {
            color: #f5e6d3;
            text-decoration: none;
            padding: 11px 24px;
            border: 2px solid #f5e6d3;
            border-radius: 2px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
            cursor: pointer;
            background-color: transparent;
            letter-spacing: 1px;
        }

        #buttons:hover {
            background-color: #f5e6d3;
            color: #6b5b4c;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 20px;
        }

        .profile-card {
            background-color: #f5e6d3;
            padding: 50px 40px;
            width: 100%;
            max-width: 500px;
            border: 3px solid #9e8b7e;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .profile-card h2 {
            font-size: 28px;
            color: #6b5b4c;
            margin-bottom: 30px;
            font-weight: 700;
            font-style: italic;
            text-align: center;
            border-bottom: 2px solid #9e8b7e;
            padding-bottom: 15px;
        }

        .profile-card h3 {
            font-size: 20px;
            color: #8b7765;
            margin-bottom: 20px;
            text-align: center;
        }

        .profile-info {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #fcf8f3;
            border-left: 4px solid #9e8b7e;
            border-radius: 4px;
        }

        .profile-info label {
            font-weight: 600;
            color: #6b5b4c;
            display: block;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .profile-info p {
            color: #8b7765;
            font-size: 16px;
            word-break: break-word;
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            justify-content: center;
        }

        .btn {
            padding: 12px 24px;
            border: 2px solid #6b5b4c;
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            letter-spacing: 1px;
        }

        .btn-logout {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            border-color: #c0392b;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(231, 76, 60, 0.3);
            background: linear-gradient(135deg, #ec7063 0%, #e74c3c 100%);
        }

        .btn-home {
            background: linear-gradient(135deg, #9e8b7e 0%, #8b7765 100%);
            color: #f5e6d3;
            border-color: #6b5b4c;
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #a67c52 0%, #9e8b7e 100%);
        }

        .no-login {
            text-align: center;
            color: #6b5b4c;
            font-size: 16px;
        }

        .no-login a {
            color: #a67c52;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .no-login a:hover {
            color: #8b6f47;
        }

        footer {
            background: linear-gradient(135deg, #6b5b4c 0%, #8b7765 100%);
            color: #f5e6d3;
            padding: 20px 40px;
            text-align: center;
            margin-top: 60px;
            border-top: 4px solid #4a3f36;
        }

        footer a {
            color: #f5e6d3;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #a67c52;
        }
    </style>
</head>
<body>
    <header class="top-bar">
        <h1>Shoply</h1>
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
        <p>&copy; 2026 Shoply. All rights reserved.</p>
    </footer>
</body>
</html>