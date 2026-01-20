<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shoply</title>
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

        #sale {
            background: linear-gradient(135deg, #e8dcc8 0%, #d4c4b0 100%);
            padding: 60px 40px;
            min-height: auto;
            border-top: 4px solid #9e8b7e;
            border-bottom: 4px solid #9e8b7e;
        }

        .sale-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .sale-header h2 {
            font-size: 36px;
            color: #6b5b4c;
            margin-bottom: 10px;
            font-weight: 700;
            font-style: italic;
        }

        .sale-header p {
            font-size: 15px;
            color: #8b7765;
            letter-spacing: 1px;
        }

        #saleItems {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 28px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .saleItem {
            background-color: #f5e6d3;
            border: 3px solid #9e8b7e;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .saleItem:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border-color: #6b5b4c;
        }

        .saleItem img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
            border-bottom: 2px solid #9e8b7e;
        }

        .saleItem:hover img {
            transform: scale(1.05);
        }

        .saleItem h4 {
            padding: 18px;
            font-size: 15px;
            color: #6b5b4c;
            font-weight: 600;
            text-align: center;
        }

        .saleItem a {
            color: #6b5b4c;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .saleItem a:hover {
            color: #a67c52;
        }

        footer {
            background: linear-gradient(135deg, #6b5b4c 0%, #8b7765 100%);
            color: #f5e6d3;
            padding: 50px 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-top: 60px;
            border-top: 4px solid #4a3f36;
        }

        footer div {
            text-align: left;
        }

        footer div h4 {
            font-size: 16px;
            margin-bottom: 12px;
            font-weight: 600;
            color: #f5e6d3;
            font-style: italic;
        }

        footer div p {
            font-size: 13px;
            line-height: 1.8;
            color: #e8dcc8;
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
                <h2>Exclusive Offers</h2>
                <p>Discover amazing deals on your favorite products</p>
            </div>
            <div id="saleItems">
                <div class="saleItem">
                    <img src="imagematerials/Blondie Direct From New York City Blondie Live At The Old Waldorf Vintage Shirt.jpg" alt="Blondie Vintage Shirt">
                    <h4><a href="register.php">Blondie Vintage Shirt - Up to 40% off</a></h4>
                </div>
                <div class="saleItem">
                    <img src="imagematerials/Fleetwood Mac Sisters Of The Moon 2023 Black T.jpg" alt="Fleetwood Mac Tee">
                    <h4><a href="register.php">Fleetwood Mac Sisters Tee - Up to 35% off</a></h4>
                </div>
                <div class="saleItem">
                    <img src="imagematerials/Manga-Inspired GUESS Jacket – Gothic Style Meets Luxury.jpg" alt="GUESS Manga Jacket">
                    <h4><a href="register.php">GUESS Manga Jacket - Up to 50% off</a></h4>
                </div>
                <div class="saleItem">
                    <img src="imagematerials/Radiohead Vintage Black T-Shirt.jpg" alt="Radiohead Tee">
                    <h4><a href="register.php">Radiohead Vintage Tee - Up to 30% off</a></h4>
                </div>
                <div class="saleItem">
                    <img src="imagematerials/Texas Natural Drink Dr Pepper Short Sleeve T Shirt.jpg" alt="Dr Pepper Shirt">
                    <h4><a href="register.php">Dr Pepper Vintage Shirt - Up to 25% off</a></h4>
                </div>
                <div class="saleItem">
                    <img src="imagematerials/Vintage Corduroy And Suede Contrast Lapel Jacket.jpg" alt="Corduroy Jacket">
                    <h4><a href="register.php">Vintage Corduroy Jacket - Up to 45% off</a></h4>
                </div>
                <div class="saleItem">
                    <img src="imagematerials/Vintage Fleetwood Mac Rumours Music Aesthetic Inpsired Tee.jpg" alt="Fleetwood Mac Rumours Tee">
                    <h4><a href="register.php">Fleetwood Mac Rumours Tee - Up to 35% off</a></h4>
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