<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


if (!isset($_SESSION['snake'])) {
    $_SESSION['snake'] = [[5,5]];
    $_SESSION['direction'] = "RIGHT";
    $_SESSION['food'] = [rand(1,8), rand(1,8)];
    $_SESSION['score'] = 0;
}

if (isset($_POST['move'])) {
    $_SESSION['direction'] = $_POST['move'];
}

$snake = $_SESSION['snake'];
$head = $snake[0];

switch ($_SESSION['direction']) {
    case "UP": $head[1]--; break;
    case "DOWN": $head[1]++; break;
    case "LEFT": $head[0]--; break;
    case "RIGHT": $head[0]++; break;
}

if ($head[0] < 0 || $head[0] > 9 || $head[1] < 0 || $head[1] > 9) {
    header("Location: save_score.php");
    exit;
}

array_unshift($snake, $head);

if ($head == $_SESSION['food']) {
    $_SESSION['score']++;
    $_SESSION['food'] = [rand(1,8), rand(1,8)];
} else {
    array_pop($snake);
}

$_SESSION['snake'] = $snake;
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Snake</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">

    <h1>Snake Game</h1>
    <h2>Player: <?php echo $_SESSION['username']; ?></h2>
    <h2>Score: <?php echo $_SESSION['score']; ?></h2>

    <div class="game-board">
        <table>
        <?php
        for ($y=0; $y<10; $y++) {
            echo "<tr>";
            for ($x=0; $x<10; $x++) {
                if (in_array([$x,$y], $_SESSION['snake'])) {
                    echo "<td class='snake'></td>";
                } elseif ($_SESSION['food'] == [$x,$y]) {
                    echo "<td class='food'></td>";
                } else {
                    echo "<td></td>";
                }
            }
            echo "</tr>";
        }
        ?>
        </table>
    </div>

    <div class="controls">
        <form method="post">
            <button name="move" value="UP">⬆</button><br>
            <button name="move" value="LEFT">⬅</button>
            <button name="move" value="DOWN">⬇</button>
            <button name="move" value="RIGHT">➡</button>
        </form>
    </div>

    <br>
    <a href="logout.php">Logout</a>

</div>
</body>
</html>

