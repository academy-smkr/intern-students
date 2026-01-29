<?php
$conn = mysqli_connect("localhost", "root", "", "employee _info");

if (!$conn) {
    die("Connection failed");
}

// Select data
$sql = "SELECT * FROM employees";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registered Employees</title>
    <style>
        table {
            border-collapse: collapse;
            width: 70%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Registered Employees List</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Salary</th>
    </tr>

<?php
// Check if records exist
if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['mobile']."</td>";
        echo "<td>".$row['salary']."</td>";
        echo "</tr>";
    }

} else {
    echo "<tr><td colspan='5'>No records found</td></tr>";
}
?>

</table>

</body>
</html>