<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$uid = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shopping Cart - MyShop</title>
<style>
:root {
    --primary-color: #8B6F47;
    --secondary-color: #C17D51;
    --accent-color: #D4A574;
    --dark-color: #5D4E37;
    --light-color: #f8f9fa;
    --border-color: #dadce0;
    --shadow-1: 0 2px 8px rgba(0, 0, 0, 0.08);
    --shadow-2: 0 4px 16px rgba(0, 0, 0, 0.12);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', 'Helvetica Neue', -apple-system, BlinkMacSystemFont, sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #f8f9fa 100%);
    margin: 0;
    color: var(--dark-color);
    font-size: 15px;
    font-weight: 400;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* HEADER */
.header {
    background: linear-gradient(135deg, #8B6F47 0%, #6B5638 100%);
    padding: 18px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: var(--shadow-2);
    color: white;
    flex-wrap: wrap;
    gap: 20px;
}

.header h3 {
    margin: 0;
    font-size: 26px;
    font-weight: 800;
    letter-spacing: -0.5px;
}

.navbar-left,
.navbar-right {
    display: flex;
    align-items: center;
    gap: 25px;
}

.navbar-left {
    flex: 1;
    position: relative;
}

.search-container {
    position: relative;
    width: 100%;
    max-width: 300px;
}

.search-input {
    width: 100%;
    padding: 10px 16px 10px 40px;
    border: none;
    border-radius: 25px;
    background: rgba(255, 255, 255, 0.15);
    color: white;
    font-size: 14px;
    transition: var(--transition);
    font-family: inherit;
}

.search-input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.search-input:focus {
    outline: none;
    background: rgba(255, 255, 255, 0.25);
    box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.2);
}

.search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: white;
    opacity: 0.7;
}

.search-results {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background: white;
    border-radius: 8px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    max-height: 400px;
    overflow-y: auto;
    z-index: 1001;
    margin-top: 8px;
    display: none;
}

.search-results.active {
    display: block;
}

.search-result-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    cursor: pointer;
    transition: var(--transition);
    border-bottom: 1px solid #f0f0f0;
}

.search-result-item:hover {
    background: #f5f5f5;
}

.search-result-img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 4px;
}

.search-result-info {
    flex: 1;
}

.search-result-name {
    font-weight: 600;
    color: var(--dark-color);
    font-size: 14px;
}

.search-result-price {
    color: var(--primary-color);
    font-size: 13px;
    font-weight: 700;
}

.header a {
    text-decoration: none;
    color: white;
    font-weight: 700;
    font-size: 13px;
    letter-spacing: 0.3px;
    transition: var(--transition);
    position: relative;
    text-transform: capitalize;
}

.header a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background: #ff6b35;
    transition: width 0.3s ease;
}

.header a:hover::after {
    width: 100%;
}

/* CART */
.cart-container {
    max-width: 1000px;
    margin: 40px auto;
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: var(--shadow-1);
    border: 1px solid var(--border-color);
}

.cart-container h2 {
    margin-top: 0;
    color: var(--dark-color);
    font-size: 28px;
    font-weight: 800;
    letter-spacing: -0.3px;
}

/* TABLE STYLING */
.table-container {
    overflow-x: auto;
    margin: 30px 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

th, td {
    padding: 16px;
    text-align: center;
    border-bottom: 1px solid var(--border-color);
    font-size: 14px;
}

th {
    background: linear-gradient(135deg, #f5f7fa, #f8f9fa);
    color: var(--dark-color);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}

td {
    color: #666;
}

tr:last-child td {
    border-bottom: none;
}

tr:hover {
    background-color: #f8f9fa;
}

th:first-child,
td:first-child {
    text-align: left;
}

.product-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    transition: var(--transition);
}

.product-img:hover {
    transform: scale(1.05);
}

.qty-box {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
}

.qty-box a {
    padding: 6px 10px;
    background: linear-gradient(135deg, var(--primary-color), #6B5638);
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 600;
    transition: var(--transition);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 30px;
    height: 30px;
}

.qty-box a:hover {
    box-shadow: 0 4px 12px rgba(26, 115, 232, 0.3);
    transform: translateY(-2px);
}

.qty-box span {
    min-width: 40px;
    text-align: center;
    font-weight: 600;
}

/* TOTALS SECTION */
.totals-section {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 2px solid var(--border-color);
    display: flex;
    justify-content: flex-end;
    gap: 50px;
}

.total {
    font-size: 20px;
    font-weight: 700;
    color: var(--accent-color);
}

/* PAYMENT METHOD */
.payment-section {
    background: linear-gradient(135deg, #f5f7fa, #f8f9fa);
    padding: 30px;
    border-radius: 12px;
    margin-top: 35px;
    border: 1px solid var(--border-color);
}

.payment-section h3 {
    margin-top: 0;
    color: var(--dark-color);
    font-size: 18px;
    font-weight: 800;
    letter-spacing: -0.3px;
}

.payment-methods {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin: 20px 0 30px 0;
}

.payment-option {
    display: flex;
    align-items: center;
    padding: 15px;
    background: white;
    border-radius: 8px;
    border: 2px solid var(--border-color);
    cursor: pointer;
    transition: var(--transition);
}

.payment-option:hover {
    border-color: var(--primary-color);
    box-shadow: 0 2px 8px rgba(26, 115, 232, 0.1);
}

.payment-option input[type="radio"] {
    margin-right: 12px;
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: var(--primary-color);
}

.payment-option label {
    cursor: pointer;
    flex: 1;
    font-weight: 600;
    font-size: 14px;
}

/* BUTTONS */
.checkout-btn {
    display: inline-block;
    width: 100%;
    max-width: 300px;
    margin: 20px auto 0;
    text-align: center;
    padding: 14px;
    background: linear-gradient(135deg, var(--secondary-color), #9a6b44);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    border: none;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 2px 8px rgba(193, 125, 81, 0.3);
}

.checkout-btn:hover {
    background: linear-gradient(135deg, #9a6b44, #7a5a37);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(154, 107, 68, 0.4);
}

/* EMPTY CART */
.empty-cart {
    text-align: center;
    padding: 60px 20px;
}

.empty-cart .icon {
    font-size: 80px;
    margin-bottom: 20px;
}

.empty-cart h3 {
    font-size: 24px;
    color: var(--dark-color);
    margin: 20px 0 10px 0;
    font-weight: 800;
    letter-spacing: -0.3px;
}

.empty-cart p {
    color: #666;
    margin-bottom: 30px;
    font-size: 15px;
}

.empty-cart a {
    display: inline-block;
    margin-top: 15px;
    padding: 12px 30px;
    background: linear-gradient(135deg, var(--primary-color), #6B5638);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: var(--transition);
    box-shadow: 0 2px 8px rgba(139, 111, 71, 0.3);
}

.empty-cart a:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(139, 111, 71, 0.4);
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .header {
        flex-direction: column;
        gap: 15px;
        padding: 15px 20px;
    }

    .header a {
        margin-left: 15px;
    }

    .cart-container {
        padding: 20px;
        margin: 20px 10px;
    }

    th, td {
        padding: 12px 8px;
        font-size: 12px;
    }

    .product-img {
        width: 60px;
        height: 60px;
    }

    .totals-section {
        flex-direction: column;
        gap: 15px;
        justify-content: center;
        text-align: right;
    }

    .payment-methods {
        grid-template-columns: 1fr;
    }
}
</style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <h3>E-Commerce</h3>
    <div class="navbar-left">
        <div class="search-container">
            <span class="search-icon">🔍</span>
            <input type="text" class="search-input" id="searchInput" placeholder="Search products...">
            <div class="search-results" id="searchResults"></div>
        </div>
    </div>
    <div class="navbar-right">
        <a href="../index.php">Home</a>
        <a href="../products.php">Products</a>
        <a href="cart.php">Cart</a>
    </div>
</div>

<div class="cart-container">
<h2>Your Cart</h2>

<?php
$sql = "
    SELECT 
        c.id AS cart_id,
        p.name,
        p.price,
        p.image,
        c.qty
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $total = 0;
    $defaultImg = "../assets/images/no-image.png";

    echo "<div class='table-container'><table>
        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>";

    while ($row = $result->fetch_assoc()) {

        $sub = $row['price'] * $row['qty'];
        $total += $sub;

        if (!empty($row['image'])) {
            $img = "../assets/images/" . $row['image'];
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $img)) {
                $img = $defaultImg;
            }
        } else {
            $img = $defaultImg;
        }

        echo "<tr>
            <td style='text-align: left;'><img src='$img' class='product-img'></td>
            <td style='text-align: left;'>{$row['name']}</td>
            <td>₹" . number_format($row['price'], 2) . "</td>
            <td>
                <div class='qty-box'>
                    <a href='update.php?id={$row['cart_id']}&type=dec'>−</a>
                    <span>{$row['qty']}</span>
                    <a href='update.php?id={$row['cart_id']}&type=inc'>+</a>
                </div>
            </td>
            <td>₹" . number_format($sub, 2) . "</td>
        </tr>";
    }

    echo "</table></div>";
    echo "<div class='totals-section'>
        <div class='total'><b>Total: ₹" . number_format($total, 2) . "</b></div>
    </div>";
    
    echo "<form action='../payment/checkout.php' method='POST'>
        <div class='payment-section'>
            <h3>Select Payment Method</h3>
            <div class='payment-methods'>
                <div class='payment-option'>
                    <input type='radio' id='cod' name='method' value='COD' required>
                    <label for='cod'>Cash on Delivery</label>
                </div>
                <div class='payment-option'>
                    <input type='radio' id='online' name='method' value='ONLINE'>
                    <label for='online'>Online Payment</label>
                </div>
            </div>
            <button type='submit' class='checkout-btn'>Place Order</button>
        </div>
    </form>";

} else {

    // EMPTY CART UI
    echo "
    <div class='empty-cart'>
        <div class='icon'>🛒</div>
        <h3>Cart is Empty</h3>
        <p>Your shopping cart doesn't have any products yet.</p>
        <a href='../products.php'>Continue Shopping</a>
    </div>";
}
?>

</div>

<!-- ===== SEARCH SCRIPT ===== -->
<script>
const searchInput = document.getElementById('searchInput');
const searchResults = document.getElementById('searchResults');

searchInput.addEventListener('input', function() {
    const query = this.value.trim();
    
    if (query.length < 2) {
        searchResults.classList.remove('active');
        return;
    }
    
    fetch('../search.php?q=' + encodeURIComponent(query))
        .then(response => response.text())
        .then(data => {
            searchResults.innerHTML = data;
            if (data.trim()) {
                searchResults.classList.add('active');
            } else {
                searchResults.classList.remove('active');
            }
        });
});

document.addEventListener('click', function(event) {
    if (!event.target.closest('.search-container')) {
        searchResults.classList.remove('active');
    }
});

document.addEventListener('click', function(event) {
    if (event.target.closest('.search-result-item')) {
        const productId = event.target.closest('.search-result-item').dataset.productId;
        if (productId) {
            window.location.href = '../products_details.php?id=' + productId;
        }
    }
});
</script>

</div>

</body>
</html>