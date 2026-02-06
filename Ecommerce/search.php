<?php
include 'config/db.php';

// Get search query
$q = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '';

// Return empty if query is too short
if (strlen(trim($q)) < 2) {
    exit;
}

// Prepare and execute search query
$search_term = '%' . $q . '%';
$sql = "SELECT id, name, price, image 
        FROM products 
        WHERE name LIKE ? OR description LIKE ? 
        LIMIT 10";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "<div class='search-result-item'>Error: " . $conn->error . "</div>";
    exit;
}

$stmt->bind_param("ss", $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are results
if ($result->num_rows === 0) {
    echo "<div class='search-result-item' style='text-align: center; padding: 20px; color: #999;'>No products found</div>";
    exit;
}

// Build HTML for search results
while ($row = $result->fetch_assoc()) {
    $id = htmlspecialchars($row['id']);
    $name = htmlspecialchars($row['name']);
    $price = number_format($row['price'], 2);
    $image = htmlspecialchars($row['image']);
    
    echo "<div class='search-result-item' data-product-id='{$id}'>";
    echo "  <img src='{$image}' alt='{$name}' class='search-result-img'>";
    echo "  <div class='search-result-info'>";
    echo "    <div class='search-result-name'>{$name}</div>";
    echo "    <div class='search-result-price'>P {$price}</div>";
    echo "  </div>";
    echo "</div>";
}

$stmt->close();
?>
