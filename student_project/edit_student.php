<?php
include 'config.php';

$message = "";

// 1️⃣ Get student ID from URL
if (!isset($_GET['id'])) {
    header("Location: view_students.php");
    exit;
}

$id = (int)$_GET['id'];

// 2️⃣ Fetch existing student data
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: view_students.php");
    exit;
}

$student = $result->fetch_assoc();

// 3️⃣ Update student
if (isset($_POST['update'])) {

    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $course = $_POST['course'];

    // Image handling
    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo']['name'];
        $tmp   = $_FILES['photo']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $photo);
    } else {
        $photo = $student['photo']; // keep old image
    }

    $update = $conn->prepare(
        "UPDATE students SET name=?, email=?, course=?, photo=? WHERE id=?"
    );
    $update->bind_param("ssssi", $name, $email, $course, $photo, $id);
    $update->execute();

    $message = "Student updated successfully";

    // refresh data
    $student['name'] = $name;
    $student['email'] = $email;
    $student['course'] = $course;
    $student['photo'] = $photo;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f8;
        }
        .box {
            width: 420px;
            margin: 60px auto;
            padding: 25px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            text-align: center;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            font-size: 16px;
        }
        .msg {
            text-align: center;
            color: green;
            margin-bottom: 10px;
        }
        .img-preview {
            text-align: center;
            margin: 10px 0;
        }
        .img-preview img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 2px solid #ccc;
        }
        .back {
            text-align: center;
            margin-top: 15px;
        }
        .back a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Edit Student</h2>

    <?php if ($message): ?>
        <p class="msg"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <input type="text" name="name"
               value="<?php echo htmlspecialchars($student['name']); ?>" required>

        <input type="email" name="email"
               value="<?php echo htmlspecialchars($student['email']); ?>" required>

        <select name="course" required>
            <option value="">Select Course</option>
            <option <?php if($student['course']=="PHP") echo "selected"; ?>>PHP</option>
            <option <?php if($student['course']=="Java") echo "selected"; ?>>Java</option>
            <option <?php if($student['course']=="Python") echo "selected"; ?>>Python</option>
        </select>

        <div class="img-preview">
            <img src="uploads/<?php echo htmlspecialchars($student['photo']); ?>">
            <p>Current Photo</p>
        </div>

        <input type="file" name="photo">

        <button name="update">Update Student</button>
    </form>

    <div class="back">
        <a href="view_students.php">⬅ Back to Students</a>
    </div>
</div>

</body>
</html>