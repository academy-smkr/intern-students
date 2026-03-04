<?php
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>
<link rel="stylesheet" href="../assets/css/admin.css?v=2.0">
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            background: #f8f9fa;
            color: #495057;
            padding: 20px;
            box-sizing: border-box;
        }

        .sidebar h2 {
            margin-top: 0;
            text-align: center;
        }

        .sidebar a {
            display: block;
            color: #495057;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
            border-radius: 4px;
        }

        .sidebar a:hover {
            background: #e9ecef;
        }

        /* MAIN CONTENT */
        .main {
            flex: 1;
            padding: 30px;
        }

        .main h1 {
            margin-top: 0;
        }

        /* DASHBOARD CARDS */
        .cards {
            display: flex;
            gap: 20px;
            margin-top: 30px;
        }

        .card {
            background: #fff;
            flex: 1;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        .card h3 {
            margin-bottom: 15px;
            color: #777;
        }

        .card h1 {
            margin: 0;
            color: #6c757d;
            font-size: 48px;
        }
    </style>
</head>
<body>

</head>
<body>
