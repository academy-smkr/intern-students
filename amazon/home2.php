<?php
session_start();
if(isset($_POST["user"])){
    $_SESSION["user"] = $_POST["user"];
    $_SESSION["phno"] = $_POST["phno"];
}

if (isset($_POST['item_name'])) {
    $_SESSION['cart'][] = $_POST['item_name'];
}
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
            background: url(sal.jpg);
            background-size: cover;
            color: red;
            height: 6vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.8rem;
            font-weight: bold;
            letter-spacing: 4px;
            animation: sale 0.5s ease-in-out 0s 100 normal;
        }

        @keyframes sale{
            0%{
                font-size: 1.8rem;
                color: red;
            }
            50%{
                font-size: 2rem;
                color: green;
            }
            100%{
                font-size: 1.8rem;
                color: blue;
            }
        }

        #saleItems{
            height: 80vh;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
        }

        .saleItem button{
            margin-top: 5px;
            padding: 4px 7px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .saleItem button:hover{
            background-color: #ff3b3b;
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
            Welcome to My shop.in &#9829; <?php echo $_SESSION["user"];?>
        </h1>
        <h3>
            <a href="cart.php" id="buttons">My cart</a>
            <a href="logout.php" id="buttons">logout</a>
            <a href="userdetails.php" id="buttons">User</a>
        </h3>
    </header>

    <main>
        <div id="sale">
            SALE SALE SALE !!!!
        </div>
        <div id="saleItems">
            <div class="saleItem">
                <form method="post">
                    <img src="p2.jpg" alt="mixer">
                    <h4>upto 70% off on Kitchen Essentials</h4>
                    <input type="hidden" name="item_name" value="Kitchen Essentials">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
                
            </div>
            <div class="saleItem">
                <form method="post">
                    <img src="p1.jpg" alt="iphone">
                    <h4>upto 25% off on Iphones</h4>
                    <input type="hidden" name="item_name" value="Iphones">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
            <div class="saleItem">
                <form method="post">
                    <img src="p7.jpg" alt="Sports and fitness">
                    <h4>upto 30% off on Fitness Essentials</h4>
                    <input type="hidden" name="item_name" value="fitness">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
            <div class="saleItem">
                <form method="post">
                    <img src="p4.jpg" alt="cosmetics">
                    <h4>upto 50% off on Cosmetics</h4>
                    <input type="hidden" name="item_name" value="cosmetics">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
            <div class="saleItem">
                <form method="post">
                    <img src="p5.jpg" alt="women's wear">
                    <h4>upto 90% off on Women's Wear</h4>
                    <input type="hidden" name="item_name" value="women's wear">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
            <div class="saleItem">
                <form method="post">
                    <img src="p6.jpg" alt="Home Essentials">
                    <h4>upto 60% off on Home Essentials</h4>
                    <input type="hidden" name="item_name" value="HomeEssentials">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
            <div class="saleItem">
                <form method="post">
                    <img src="p3.jpg" alt="TV">
                    <h4>upto 30% cashback on TVs</h4>
                    <input type="hidden" name="item_name" value="TV">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
            <div class="saleItem">
                <form method="post">
                    <img src="p8.jpg" alt="Furniture">
                    <h4>3 Year warenty on Furniture Items</h4>
                    <input type="hidden" name="item_name" value="Furniture">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
        </div>
        </form>
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