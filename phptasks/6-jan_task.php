<!DOCTYPE html>
<html>
<head>
    <title>Employee Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2>Employee Details</h2>
    </header>

    <main>
        <?php
        echo "<div class = 'ab'>";
        $Employee = [
            [
                "name" => "Emp1",
                "basicSalary" => 50000
            ],
            
            [
                "name" => "Emp2",
                "basicSalary" => 70000
            ],

            [
                "name" => "Emp3",
                "basicSalary" => 50000
            ],

            [
                "name" => "Emp4",
                "basicSalary" => 50000
            ],

            [
                "name" => "Emp5",
                "basicSalary" => 50000
            ],
        ];

        foreach ($Employee as $emp){
            echo "<span class = 'a'>";
            $HRA = 0.2 * $emp["basicSalary"];
            $DA = 0.1 * $emp["basicSalary"];
            $totalSalary = $emp["basicSalary"] + $HRA + $DA;
            echo "<b>Employee Name : ".$emp["name"]."</b><br>";
            echo "Basic salary : ".$emp["basicSalary"]."<br>";
            echo "HRA : ".$HRA."<br>";
            echo "DA : ".$DA."<br>";
            echo "<span class='total'>Total Salary : ".$totalSalary."</span><br>";
            echo "</span>";
            // echo "<hr>";
            
        }
        echo "</span>";
        ?>
    </main>
</body>
</html>
