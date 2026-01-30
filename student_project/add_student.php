<?php
session_start();
include 'config.php';

$name = $email = $course = "";
$error = $success = "";

// Handle form submission
if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);

    // Upload photo
    $photo = $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];
    $upload_dir = "uploads/";

    if (empty($name) || empty($email) || empty($course) || empty($photo)) {
        $error = "All fields are required!";
    } else {
        // Move uploaded file
        $target_file = $upload_dir . basename($photo);
        if (move_uploaded_file($tmp_name, $target_file)) {
            // Insert into database
            $sql = "INSERT INTO students (name, email, course, photo) 
                    VALUES ('$name', '$email', '$course', '$photo')";
            if (mysqli_query($conn, $sql)) {
                $success = "Student added successfully!";
                // Reset fields
                $name = $email = $course = "";
            } else {
                $error = "Database error: " . mysqli_error($conn);
            }
        } else {
            $error = "Failed to upload photo.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <style>
        body { font-family: Arial; background: #f4f6f8; margin: 0; }
        .container { width: 40%; margin: 50px auto; background: white; padding: 20px; box-shadow: 0 0 10px #ccc; border-radius: 6px; }
        input[type=text], input[type=email], select, input[type=file] {
            width: 100%; padding: 8px; margin: 6px 0 12px 0; border: 1px solid #ccc; border-radius: 4px;
        }
        input[type=submit] {
            background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;
        }
        input[type=submit]:hover { background: #0056b3; }
        .message { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .error { background: #f8d7da; color: #721c24; }
        .success { background: #d4edda; color: #155724; }
        a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

<div class="container">
    <h2>Add Student</h2>

    <?php if($error) { echo "<div class='message error'>$error</div>"; } ?>
    <?php if($success) { echo "<div class='message success'>$success</div>"; } ?>

    <form method="post" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

        <label>Course:</label>
        <select name="course" required>
            <option value="">-- Select Course --</option>
            <option value="PHP" <?php if($course=="PHP") echo "selected"; ?>>PHP</option>
            <option value="Java" <?php if($course=="Java") echo "selected"; ?>>Java</option>
            <option value="Python" <?php if($course=="Python") echo "selected"; ?>>Python</option>
        </select>

        <label>Photo:</label>
        <input type="file" name="photo" accept="image/*" required>

        <input type="submit" name="submit" value="Add Student">
    </form>

    <p><a href="view_students.php">← Back to Students</a></p>
</div>

</body>
</html>