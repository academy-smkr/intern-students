<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$msg = "";

if (isset($_POST['submit'])) {

    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category    = mysqli_real_escape_string($conn, $_POST['category']);
    $location    = mysqli_real_escape_string($conn, $_POST['location']);
    $status      = mysqli_real_escape_string($conn, $_POST['status']);

    // IMAGE UPLOAD
    $image = "";
    if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        $img_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $new_name = "item_" . time() . "." . $ext;
        $destination = "../assets/images/" . $new_name;

        if (move_uploaded_file($tmp_name, $destination)) {
            $image = $new_name;
        } else {
            $msg = "Image upload failed!";
        }
    }

    if ($msg == "") {
        $user_id = $_SESSION['user_id'];
        $insert = mysqli_query($conn, "INSERT INTO items (user_id,title,description,category,location,status,image) VALUES ('$user_id','$title','$description','$category','$location','$status','$image')");

        if ($insert) {
            $msg = "Item posted successfully!";
        } else {
            $msg = "Failed to post item!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Item | CampusFind</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="page-wrapper">
<div class="header">
    <div style="display:flex;align-items:center;gap:15px;">
        <img src="../assets/images/college-logo.png">
        <h1>CampusFind</h1>
    </div>
    <div>
        <a href="dashboard.php" class="btn">Dashboard</a>
        <a href="logout.php" class="btn">Logout</a>
    </div>
</div>

<div class="container">
    <div class="card" style="max-width:600px;margin:auto;">
        <h2>Post Lost / Found Item</h2>

        <?php if ($msg != "") { ?>
            <p style="color:green;"><?php echo $msg; ?></p>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Item Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="text" name="category" placeholder="Category (Phone, Bag, Book, etc.)" required>
            <input type="text" name="location" placeholder="Location (Library, Lab, Canteen)" required>

            <label>Status:</label>
            <select name="status" required>
                <option value="lost">Lost</option>
                <option value="found">Found</option>
            </select>

            <label>Upload Image:</label>
            <input type="file" name="image" accept="image/*">

            <button type="submit" name="submit" class="btn">Post Item</button>
        </form>
    </div>
</div>

<div class="footer">
    © <?php echo date("Y"); ?> CampusFind
</div>
</div>
</body>
</html>
