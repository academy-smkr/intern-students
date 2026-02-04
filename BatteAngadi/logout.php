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
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .logout-container {
            background: linear-gradient(135deg, var(--bg-mid) 0%, var(--bg-darker) 100%);
            padding: 60px 40px;
            width: 100%;
            max-width: 500px;
            border: 2px solid rgba(185,155,255,0.45);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.8), inset 0 1px 0px rgba(185,155,255,0.3);
            border-radius: 0px;
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-top: 1px solid var(--light);
        }

        .logout-container:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.9), inset 0 1px 0px rgba(192, 192, 192, 0.4), 0 0 12px rgba(192, 192, 192, 0.2);
        }

        .logout-container h1 {
            font-size: 48px;
            color: var(--accent);
            margin-bottom: 10px;
            font-weight: 700;
            font-style: normal;
            font-family: 'Oswald', sans-serif;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }

        .logout-container h2 {
            font-size: 28px;
            color: var(--light);
            margin-bottom: 20px;
            font-weight: 600;
            font-family: 'Oswald', sans-serif;
            text-transform: lowercase;
        }

        .logout-container p {
            font-size: 14px;
            color: var(--accent);
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

        .btn-login {
            background: linear-gradient(180deg, var(--light) 0%, var(--accent) 100%);
            color: var(--bg-dark);
        }

        .btn-login:hover {
            background: linear-gradient(180deg, #F8F4FF 0%, var(--light) 100%);
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

        footer {
            background: linear-gradient(180deg, var(--bg-mid) 0%, var(--bg-dark) 100%);
            color: var(--accent);
            padding: 20px 40px;
            text-align: center;
            margin-top: 60px;
            width: 100%;
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