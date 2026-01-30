<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My shop.in</title>
    <style>
        *{
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            padding: 20px;
        }

        .top-bar h1 {
            color: white;
            margin: 0;
        }

        #buttons {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border: 1px solid white;
            border-radius: 6px;
            margin: 10px;
        }

        #buttons:hover {
            background-color: white;
            color: #333;
        }

        #sale{
            background: url(sa.jpg);
            height: 80vh;
            background-size: cover;
        }

        #saleItems{
            padding: 50px 60px 0px 0px;
            margin-left: 30px;
            height: 400px;
            width: 900px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .saleItem img {
            width: 250px;
            height: 150px;
            object-fit: cover;
        }

        footer{
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            display: flex;
            justify-content: space-around;
        }

        footer div{
            text-align: left;
        }
    
    </style>
</head>
<body>
    <header class="top-bar">
        <h1>
            My shop.in &#9829;
        </h1>
        <h3>
            <a href="register.php" id="buttons">Register</a>
            <a href="login.php" id="buttons">Login</a>
        </h3>
    </header>

    <main>
        <div id="sale">
            <div id="saleItems">
                <div class="saleItem">
                    <img src="p1.jpg" alt="iphone">
                    <h4><a href="register.php">upto 25% off on Iphones</a></h4>
                </div>
                <div class="saleItem">
                    <img src="p2.jpg" alt="mixer">
                    <h4><a href="register.php">upto 70% off on Kitchen Essentials</h4></a>
                </div>
                <div class="saleItem">
                    <img src="p3.jpg" alt="TV">
                    <h4><a href="register.php">upto 30% cashback on TVs</h4></a>
                </div>
                <div class="saleItem">
                    <img src="p4.jpg" alt="cosmetics">
                    <h4><a href="register.php">upto 50% off on Cosmetics</h4></a>
                </div>
                <div class="saleItem">
                    <img src="p5.jpg" alt="womens wear">
                    <h4><a href="register.php">upto 90% off on Women's Wear</h4></a>
                </div>
                <div class="saleItem">
                    <img src="p6.jpg" alt="Home essentials">
                    <h4><a href="register.php">upto 60% off on Home Essentials</h4></a>
                </div>
            </div>
        </div>

    </main>

    <footer>
        <div>
            About us: <br>
            contact : 1234567890 <br>
            email : abc@gmail.com <br>
        </div>
        <div>
            connect us on : <br>
            Instagram <br>
            Facebook <br>
        </div>
        <div>
            let us help you out: <br>
            careers<br>
            Feedback<br>
        </div>
    </footer>
    
</body>
</html>