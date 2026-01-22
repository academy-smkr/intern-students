<?php
session_start();

$username = isset($_SESSION["user"]) ? $_SESSION["user"] : "User";

session_unset();  
session_destroy();  
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logout - Batte Angadi</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Verdana&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Verdana', sans-serif;
        }

        body {
            background-color: #0a0a0a;
            background-image: 
                linear-gradient(0deg, transparent 24%, rgba(192, 192, 192, 0.05) 25%, rgba(192, 192, 192, 0.05) 26%, transparent 27%, transparent 74%, rgba(192, 192, 192, 0.05) 75%, rgba(192, 192, 192, 0.05) 76%, transparent 77%, transparent),
                linear-gradient(90deg, transparent 24%, rgba(192, 192, 192, 0.05) 25%, rgba(192, 192, 192, 0.05) 26%, transparent 27%, transparent 74%, rgba(192, 192, 192, 0.05) 75%, rgba(192, 192, 192, 0.05) 76%, transparent 77%, transparent);
            background-size: 50px 50px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .logout-container {
            background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
            padding: 60px 40px;
            width: 100%;
            max-width: 500px;
            border: 2px solid #A8A8A8;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.8), inset 0 1px 0px rgba(192, 192, 192, 0.3);
            border-radius: 0px;
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-top: 1px solid #E8E8E8;
        }

        .logout-container:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.9), inset 0 1px 0px rgba(192, 192, 192, 0.4), 0 0 12px rgba(192, 192, 192, 0.2);
        }

        .logout-container h1 {
            font-size: 48px;
            color: #C0C0C0;
            margin-bottom: 10px;
            font-weight: 700;
            font-style: normal;
            font-family: 'Oswald', sans-serif;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }

        .logout-container h2 {
            font-size: 28px;
            color: #E8E8E8;
            margin-bottom: 20px;
            font-weight: 600;
            font-family: 'Oswald', sans-serif;
            text-transform: lowercase;
        }

        .logout-container p {
            font-size: 14px;
            color: #A8A8A8;
            margin-bottom: 30px;
            line-height: 1.6;
            text-transform: lowercase;
            letter-spacing: 0.5px;
        }

        .button-group {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
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

        .btn-login {
            background: linear-gradient(180deg, #D3D3D3 0%, #A8A8A8 100%);
            color: #000000;
        }

        .btn-login:hover {
            background: linear-gradient(180deg, #FFFFFF 0%, #C0C0C0 100%);
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

        footer {
            background: linear-gradient(180deg, #2a2a2a 0%, #0a0a0a 100%);
            color: #C0C0C0;
            padding: 20px 40px;
            text-align: center;
            margin-top: 60px;
            width: 100%;
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
    <div class="logout-container">
        <h1>Batte Angadi</h1>
        <h2>✓ Successfully Logged Out</h2>
        <p>Thank you, <?php echo htmlspecialchars($username); ?>! We hope to see you again soon.</p>
        <div class="button-group">
            <a href="login.php" class="btn btn-login">Login Again</a>
            <a href="home.php" class="btn btn-home">Go to Home</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 Batte Angadi. All rights reserved.</p>
    </footer>
</body>
</html>