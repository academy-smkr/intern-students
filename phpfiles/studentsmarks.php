<!DOCTYPE html>
<html>
<head>
    <title>PHP task1</title>
</head>
<body>
    <h2>Task</h2>

    <?php
    $rollNumber = 30;
    $name = "ayush";
    $mark1 = 45;
    $mark2 = 60;
    $mark3 = 75;
    $totalMark = ($mark1 + $mark2 + $mark3);
    ?>

    <p><b>Student Roll Number : </b><?php echo $rollNumber; ?></p>
    <p><b>Student Name : </b><?php echo $name; ?></p>
    <p><b>Student Total Marks : </b><?php echo $totalMark; ?></p>
</body>
</html>