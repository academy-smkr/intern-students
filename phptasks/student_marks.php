<!DOCTYPE html>
<html>
<head>
    <title>PHP task1</title>
</head>
<body>
    <h2>Task</h2>

    <?php
    $rollNumber = 6;
    $name = "Kaushiki";
    $mark1 = 90;
    $mark2 = 80;
    $mark3 = 70;
    $totalMark = ($mark1 + $mark2 + $mark3);
    ?>

    <p><b>Student Roll Number : </b><?php echo $rollNumber; ?></p>
    <p><b>Student Name : </b><?php echo $name; ?></p>
    <p><b>Student Total Marks : </b><?php echo $totalMark; ?></p>
</body>
</html>
