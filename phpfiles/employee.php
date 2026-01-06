<?php
// Employee details stored in an array
$employee = array(
    "Name" => "Raza",
    "BasicSalary" => 45000
);

// Calculate HRA and DA
$hra = 0.20 * $employee["BasicSalary"];   // 20% of Basic Salary
$da  = 0.10 * $employee["BasicSalary"];   // 10% of Basic Salary

// Calculate Total Salary
$totalSalary = $employee["BasicSalary"] + $hra + $da;

// Display employee details
echo "<h2>Employee Salary Details</h2>";
echo "Employee Name: " . $employee["Name"] . "<br>";
echo "Basic Salary: ₹" . $employee["BasicSalary"] . "<br>";
echo "HRA (20%): ₹" . $hra . "<br>";
echo "DA (10%): ₹" . $da . "<br>";
echo "<b>Total Salary: ₹" . $totalSalary . "</b>";
?>