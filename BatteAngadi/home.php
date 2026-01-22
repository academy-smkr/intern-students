<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Batte Angadi</title>
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
            text-transform: uppercase;
            box-shadow: inset 0 1px 0px rgba(255, 255, 255, 0.6), 0 2px 4px rgba(0, 0, 0, 0.6);
        }

        #buttons:hover {
            background: linear-gradient(180deg, #FFFFFF 0%, #D3D3D3 100%);
            transform: translateY(-1px);
            box-shadow: inset 0 1px 0px rgba(255, 255, 255, 0.8), 0 4px 8px rgba(0, 0, 0, 0.7);
        }

        #sale {
            background: linear-gradient(180deg, #1a1a1a 0%, #0a0a0a 100%);
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-top: 2px solid #E8E8E8;
            border-bottom: 3px solid #C0C0C0;
            position: relative;
            overflow: hidden;
        }

        #sale::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 200px;
            height: 100%;
            background-image: 
                linear-gradient(0deg, transparent 24%, rgba(192, 192, 192, 0.08) 25%, rgba(192, 192, 192, 0.08) 26%, transparent 27%, transparent 74%, rgba(192, 192, 192, 0.08) 75%, rgba(192, 192, 192, 0.08) 76%, transparent 77%, transparent),
                linear-gradient(90deg, transparent 24%, rgba(192, 192, 192, 0.08) 25%, rgba(192, 192, 192, 0.08) 26%, transparent 27%, transparent 74%, rgba(192, 192, 192, 0.08) 75%, rgba(192, 192, 192, 0.08) 76%, transparent 77%, transparent),
                repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(192, 192, 192, 0.05) 35px, rgba(192, 192, 192, 0.05) 70px),
                repeating-linear-gradient(-45deg, transparent, transparent 35px, rgba(192, 192, 192, 0.05) 35px, rgba(192, 192, 192, 0.05) 70px);
            background-size: 50px 50px, 50px 50px, 100% 100%, 100% 100%;
            pointer-events: none;
            z-index: 1;
            opacity: 0.6;
        }

        #sale::after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            width: 200px;
            height: 100%;
            background-image: 
                linear-gradient(0deg, transparent 24%, rgba(192, 192, 192, 0.08) 25%, rgba(192, 192, 192, 0.08) 26%, transparent 27%, transparent 74%, rgba(192, 192, 192, 0.08) 75%, rgba(192, 192, 192, 0.08) 76%, transparent 77%, transparent),
                linear-gradient(90deg, transparent 24%, rgba(192, 192, 192, 0.08) 25%, rgba(192, 192, 192, 0.08) 26%, transparent 27%, transparent 74%, rgba(192, 192, 192, 0.08) 75%, rgba(192, 192, 192, 0.08) 76%, transparent 77%, transparent),
                repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(192, 192, 192, 0.05) 35px, rgba(192, 192, 192, 0.05) 70px),
                repeating-linear-gradient(-45deg, transparent, transparent 35px, rgba(192, 192, 192, 0.05) 35px, rgba(192, 192, 192, 0.05) 70px);
            background-size: 50px 50px, 50px 50px, 100% 100%, 100% 100%;
            pointer-events: none;
            z-index: 1;
            opacity: 0.6;
        }

        .sale-header {
            text-align: center;
            margin-bottom: 30px;
            width: 100%;
            position: relative;
            z-index: 10;
        }

        .sale-header h2 {
            font-size: 36px;
            color: #E8E8E8;
            margin-bottom: 10px;
            font-weight: 700;
            font-style: normal;
            text-transform: lowercase;
            letter-spacing: 1px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            font-family: 'Oswald', sans-serif;
        }

        .sale-header p {
            font-size: 14px;
            color: #C0C0C0;
            letter-spacing: 1px;
            text-transform: lowercase;
        }
        }

        #saleItems {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 20px;
            width: 100%;
            margin: 0 auto;
            padding: 0 20px;
            perspective: 1200px;
            position: relative;
            z-index: 10;
        }

        .saleItem {
            background: linear-gradient(135deg, #1a1a1a 0%, #252525 100%);
            border: 2px solid #C0C0C0;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.8), inset 0 1px 0px rgba(192, 192, 192, 0.2), -5px 5px 15px rgba(0, 0, 0, 0.5);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
            position: relative;
            border-radius: 2px;
            width: 320px;
            height: 180px;
            aspect-ratio: 16/9;
            transform-origin: center bottom;
            transform: perspective(1200px) rotateY(0deg) rotateX(0deg) scale(0.9) rotateZ(0deg);
            opacity: 0.75;
        }

        .saleItem:nth-child(odd) {
            transform: perspective(1200px) rotateZ(-12deg) rotateY(-20deg) rotateX(0deg) scale(0.88);
        }

        .saleItem:nth-child(even) {
            transform: perspective(1200px) rotateZ(12deg) rotateY(20deg) rotateX(0deg) scale(0.88);
        }

        .saleItem:nth-child(3n) {
            transform: perspective(1200px) rotateZ(-8deg) rotateY(-12deg) rotateX(2deg) scale(0.9);
        }

        .saleItem::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: repeating-linear-gradient(90deg, transparent 0px, transparent 1px, rgba(192, 192, 192, 0.03) 1px, rgba(192, 192, 192, 0.03) 2px),
                        repeating-linear-gradient(0deg, transparent 0px, transparent 1px, rgba(192, 192, 192, 0.02) 1px, rgba(192, 192, 192, 0.02) 2px);
            pointer-events: none;
            z-index: 1;
            mix-blend-mode: overlay;
        }

        .saleItem::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(192, 192, 192, 0.1) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .saleItem:hover {
            transform: perspective(1200px) rotateY(0deg) rotateX(-5deg) scale(1.35) rotateZ(0deg) !important;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.95), inset 0 1px 0px rgba(192, 192, 192, 0.3), 0 0 30px rgba(192, 192, 192, 0.5), -12px 12px 35px rgba(0, 0, 0, 0.7);
            border-color: #E8E8E8;
            z-index: 100;
            opacity: 1;
        }

        .saleItem:hover::after {
            opacity: 1;
        }

        .saleItem img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease, filter 0.3s ease;
            border-bottom: none;
            filter: contrast(1.05) saturate(0.95);
        }

        .saleItem:hover img {
            transform: scale(1.3) rotate(1deg);
            filter: contrast(1.15) saturate(1.1);
        }

        .saleItem h4 {
            padding: 15px;
            font-size: 12px;
            color: #C0C0C0;
            font-weight: 700;
            text-align: center;
            text-transform: lowercase;
            letter-spacing: 0.5px;
            background: linear-gradient(135deg, rgba(26, 26, 26, 0.95) 0%, rgba(37, 37, 37, 0.95) 100%);
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .saleItem a {
            color: #E8E8E8;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .saleItem:hover h4 {
            opacity: 1;
        }

        .saleItem a:hover {
            color: #FFFFFF;
        }

        footer {
            background: linear-gradient(180deg, #2a2a2a 0%, #0a0a0a 100%);
            color: #C0C0C0;
            padding: 50px 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-top: 60px;
            border-top: 3px solid #C0C0C0;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.8), inset 0 1px 0px rgba(192, 192, 192, 0.3);
        }

        footer div {
            text-align: left;
        }

        footer div h4 {
            font-size: 14px;
            margin-bottom: 12px;
            font-weight: 600;
            color: #E8E8E8;
            font-style: normal;
            text-transform: lowercase;
            letter-spacing: 0.5px;
        }

        footer div p {
            font-size: 12px;
            line-height: 1.8;
            color: #A8A8A8;
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
            <?php
            if(isset($_SESSION["user"]) && $_SESSION["is_logged_in"]) {
                echo "<a href='userdetails.php' id='buttons'>Profile</a>";
                echo "<a href='logout.php' id='buttons'>Logout</a>";
            } else {
                echo "<a href='register.php' id='buttons'>Register</a>";
                echo "<a href='login.php' id='buttons'>Login</a>";
            }
            ?>
        </div>
    </header>

    <main>
        <div id="sale">
            <div class="sale-header">
                <h2>BATTE ANGADI SALE</h2>
                <p>YOUR FASION, OUR SALE, BUY NOW</p>
            </div>
            <div id="saleItems">
                <div class="saleItem">
                    <img src="imagematerials/WhatsApp Image 2026-01-20 at 1.37.21 PM (1).jpeg" alt="LEATHER JACKETS">
                    <h4><a href="register.php">LEATHER JACKETS - Up to 20% off</a></h4>
                </div>
                <div class="saleItem">
                    <img src="imagematerials/WhatsApp Image 2026-01-20 at 1.37.21 PM.jpeg" alt="GRAPHIC SHIRTS">
                    <h4><a href="register.php">GRAPHIC SHIRTS- BUY 2 FOR 3K</a></h4>
                </div>
                <div class="saleItem">
                    <img src="imagematerials/WhatsApp Image 2026-01-20 at 1.37.20 PM (3).jpeg" alt="GRAPHIC SHIRTS">
                    <h4><a href="register.php">GRAPHIC SHIRTS - Up to 50% off</a></h4>
                </div>
                <div class="saleItem">
                    <img src="imagematerials/WhatsApp Image 2026-01-20 at 1.37.20 PM (2).jpeg" alt="GRAPHIC SHIRTS">
                    <h4><a href="register.php">GRAPHIC SHIRTS - Up to 20% off</a></h4>
                </div>
                <div class="saleItem">
                    <img src="imagematerials/WhatsApp Image 2026-01-20 at 1.37.20 PM.jpeg" alt="GRAPHIC HOODIE">
                    <h4><a href="register.php">GRAPHIC HOODIE - BUY ONE GET ONE</a></h4>
                </div>
                <div class="saleItem">
                    <img src="imagematerials/WhatsApp Image 2026-01-20 at 1.37.20 PM (1).jpeg" alt="GRAPHIC JEANS">
                    <h4><a href="register.php">GRAPHIC JEANS - Up to 45% off</a></h4>
                </div>
                <div class="saleItem">
                    <img src="imagematerials/WhatsApp Image 2026-01-20 at 1.37.19 PM.jpeg" alt="ACCESSORIES">
                    <h4><a href="register.php">ACCESSORIES - Up to 75% off</a></h4>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div>
            <h4>About Us</h4>
            <p>Your trusted online shopping destination for premium products and unbeatable deals.</p>
        </div>
        <div>
            <h4>Contact Us</h4>
            <p>Phone: 1234567890</p>
            <p>Email: <a href="mailto:abc@gmail.com">abc@gmail.com</a></p>
        </div>
        <div>
            <h4>Follow Us</h4>
            <p><a href="#">Instagram</a></p>
            <p><a href="#">Facebook</a></p>
        </div>
        <div>
            <h4>Support</h4>
            <p><a href="#">Careers</a></p>
            <p><a href="#">Feedback</a></p>
        </div>
    </footer>
    
</body>
</html>