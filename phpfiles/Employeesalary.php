<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: lightblue;
        }
    </style>
</head>
<body>
<?php
// Array to store employee details
$employees = array(
    array(
        'name' => 'akshay',
        'basicSalary' => 50000
    ),
    array(
        'name' => 'suraj',
        'basicSalary' => 60000
    ),
    array(
        'name' => 'raza',
        'basicSalary' => 55000
    ),
    array(
        'name' => 'rajesh',
        'basicSalary' => 65000
    ),
    array(
        'name' => 'vivek',
        'basicSalary' => 70000
    )
);

// Display employee details and calculate total salary
echo "<h2>Employee Salary Details</h2>";
echo "<table border='1' cellpadding='10' cellspacing='0'>";
echo "<tr>
        <th>Employee Name</th>
        <th>Basic Salary</th>
        <th>HRA (20%)</th>
        <th>DA (10%)</th>
        <th>Total Salary</th>
      </tr>";

foreach ($employees as $employee) {
    $name = $employee['name'];
    $basicSalary = $employee['basicSalary'];
    
    // Calculate HRA (20% of Basic Salary)
    $hra = $basicSalary * 0.20;
    
    // Calculate DA (10% of Basic Salary)
    $da = $basicSalary * 0.10;
    
    // Calculate Total Salary
    $totalSalary = $basicSalary + $hra + $da;
    
    // Display the details
    echo "<tr>
            <td>$name</td>
            <td>₹" . number_format($basicSalary, 2) . "</td>
            <td>₹" . number_format($hra, 2) . "</td>
            <td>₹" . number_format($da, 2) . "</td>
            <td><strong>₹" . number_format($totalSalary, 2) . "</strong></td>
          </tr>";
}

echo "</table>";
?>
</body>
</html>