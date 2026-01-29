<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f4f6f8;
        }
        .navbar {
            background: #343a40;
            padding: 15px;
            color: white;
        }
        .navbar span {
            font-size: 18px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }
        .container {
            padding: 40px;
        }
        .cards {
            display: flex;
            gap: 20px;
        }
        .card {
            background: white;
            padding: 25px;
            width: 250px;
            border-radius: 6px;
            box-shadow: 0 0 10px #ccc;
            text-align: center;
        }
        .card h3 {
            margin: 10px 0;
        }
        .card a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .card a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <span>Student Management System</span>
    <a href="logout.php" style="float:right;">Logout</a>
</div>

<!-- CONTENT -->
<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?> </h2>

    <div class="cards">
        <div class="card">
            <h3>Add Student</h3>
            <p>Create new student record</p>
            <a href="add_student.php">Add Student</a>
        </div>

        <div class="card">
            <h3>View Students</h3>
            <p>View, edit or delete students</p>
            <a href="view_students.php">View Students</a>
        </div>

        <div class="card">
            <h3>Logout</h3>
            <p>End your session safely</p>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>

</body>
</html>