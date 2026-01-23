<?php
include 'config.php';
$result = mysqli_query($conn, "SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f8;
        }
        .container {
            width: 90%;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        a.btn {
            padding: 6px 12px;
            text-decoration: none;
            color: white;
            border-radius: 4px;
            font-size: 14px;
        }
        .edit {
            background: #28a745;
        }
        .delete {
            background: #dc3545;
        }
        .edit:hover {
            background: #218838;
        }
        .delete:hover {
            background: #c82333;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .top-bar a {
            text-decoration: none;
            padding: 8px 14px;
            background: #343a40;
            color: white;
            border-radius: 4px;
        }
    </style>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this student?");
        }
    </script>
</head>
<body>

<div class="container">
    <div class="top-bar">
        <a href="dashboard.php">⬅ Dashboard</a>
        <a href="add_student.php">➕ Add Student</a>
    </div>

    <h2>Student List</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Actions</th>
        </tr>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td>
                        <img src="uploads/<?php echo htmlspecialchars($row['photo']); ?>">
                    </td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                    <td>
                        <a class="btn edit"
                           href="edit_student.php?id=<?php echo $row['id']; ?>">Edit</a>

                        <a class="btn delete"
                           href="delete_student.php?id=<?php echo $row['id']; ?>"
                           onclick="return confirmDelete();">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No students found</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>