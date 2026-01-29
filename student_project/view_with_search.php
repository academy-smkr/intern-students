<?php
include 'config.php';

$search = $_GET['search'] ?? '';
$course = $_GET['course'] ?? '';

/*
 SAFE SQL:
 - ? are placeholders
 - SQL structure is fixed
 - User input is added safely
*/
$sql = "SELECT * FROM students
        WHERE (name LIKE ? OR email LIKE ?)
        AND (? = '' OR course = ?)";

$stmt = mysqli_prepare($conn, $sql);

$searchLike = "%$search%";

mysqli_stmt_bind_param(
    $stmt,
    "ssss",
    $searchLike,  // for name LIKE ?
    $searchLike,  // for email LIKE ?
    $course,      // for ? = ''
    $course       // for course = ?
);

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
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
        .edit { background: #28a745; }
        .delete { background: #dc3545; }
        .edit:hover { background: #218838; }
        .delete:hover { background: #c82333; }

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

        .search-box {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        .search-box input,
        .search-box select {
            padding: 8px;
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

    <!-- SEARCH & FILTER FORM -->
    <form method="GET" class="search-box">
        <input type="text" name="search"
               placeholder="Search name or email"
               value="<?php echo htmlspecialchars($search); ?>">

        <select name="course">
            <option value="">All Courses</option>
            <option value="PHP" <?php if($course=="PHP") echo "selected"; ?>>PHP</option>
            <option value="Java" <?php if($course=="Java") echo "selected"; ?>>Java</option>
            <option value="Python" <?php if($course=="Python") echo "selected"; ?>>Python</option>
        </select>

        <button type="submit">Search</button>
    </form>

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
