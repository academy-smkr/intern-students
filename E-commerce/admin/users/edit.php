<?php
include '../../config/db.php';

$id = $_GET['id'];

// fetch old data
$result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
$user = mysqli_fetch_assoc($result);

// update data
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    mysqli_query(
        $conn,
        "UPDATE users SET name='$name', email='$email' WHERE id=$id"
    );

    header("Location: list.php");
    exit;
}
?>

<form method="POST">
    <input type="text" name="name" value="<?= $user['name'] ?>" required>
    <input type="email" name="email" value="<?= $user['email'] ?>" required>
    <button name="update">Update</button>
</form>