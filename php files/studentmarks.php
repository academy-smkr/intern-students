<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: blue;
            color: white;
            font-family: Arial, sans-serif;
            font-weight: bold;
            padding: 20px;
        }
    </style>
</head>
<body>
<?php
// Student details
$rollNo = 40;
$name = "rob";

// Marks of three subjects
$mark1 = 98;
$mark2 = 87;
$mark3 = 85;

// Calculate total marks
$total = $mark1 + $mark2 + $mark3;

// Display details
echo "Roll Number: " . $rollNo . "<br>";
echo "Name: " . $name . "<br>";
echo "Marks 1: " . $mark1 . "<br>";
echo "Marks 2: " . $mark2 . "<br>";
echo "Marks 3: " . $mark3 . "<br>";
echo "Total Marks: " . $total;
?>
</body>
</html>