<?php
session_start();

$username = isset($_SESSION["user"]) ? $_SESSION["user"] : "User";

session_unset();  
session_destroy();  
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logout - Shoply</title>
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
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .logout-container {
            background-color: #f5e6d3;
            padding: 60px 40px;
            width: 100%;
            max-width: 500px;
            border: 3px solid #9e8b7e;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .logout-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .logout-container h1 {
            font-size: 36px;
            color: #6b5b4c;
            margin-bottom: 10px;
            font-weight: 700;
            font-style: italic;
        }

        .logout-container h2 {
            font-size: 28px;
            color: #556b2f;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .logout-container p {
            font-size: 16px;
            color: #8b7765;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .button-group {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
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

        .btn-login {
            background: linear-gradient(135deg, #9e8b7e 0%, #8b7765 100%);
            color: #f5e6d3;
            border-color: #6b5b4c;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #a67c52 0%, #9e8b7e 100%);
        }

        .btn-home {
            background: linear-gradient(135deg, #6b5b4c 0%, #8b7765 100%);
            color: #f5e6d3;
            border-color: #4a3f36;
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #8b7765 0%, #9e8b7e 100%);
        }

        footer {
            background: linear-gradient(135deg, #6b5b4c 0%, #8b7765 100%);
            color: #f5e6d3;
            padding: 20px 40px;
            text-align: center;
            margin-top: 60px;
            width: 100%;
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
    <div class="logout-container">
        <h1>Shoply</h1>
        <h2>✓ Successfully Logged Out</h2>
        <p>Thank you, <?php echo htmlspecialchars($username); ?>! We hope to see you again soon.</p>
        <div class="button-group">
            <a href="login.php" class="btn btn-login">Login Again</a>
            <a href="home.php" class="btn btn-home">Go to Home</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 Shoply. All rights reserved.</p>
    </footer>
</body>
</html>