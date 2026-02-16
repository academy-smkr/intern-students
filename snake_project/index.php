<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$gridSize = 20;

if (!isset($_SESSION['snake'])) {
    $_SESSION['snake'] = [
        [10,10],
        [9,10],
        [8,10]
    ];
    $_SESSION['direction'] = "RIGHT";
    $_SESSION['food'] = [rand(0,19), rand(0,19)];
    $_SESSION['score'] = 0;
}

if (isset($_POST['dir'])) {
    $_SESSION['direction'] = $_POST['dir'];
}

$snake = $_SESSION['snake'];
$head = $snake[0];

switch ($_SESSION['direction']) {
    case "UP": $head[1]--; break;
    case "DOWN": $head[1]++; break;
    case "LEFT": $head[0]--; break;
    case "RIGHT": $head[0]++; break;
}

array_unshift($snake, $head);

if ($head == $_SESSION['food']) {
    $_SESSION['score']++;
    $_SESSION['food'] = [rand(0,19), rand(0,19)];
} else {
    array_pop($snake);
}

if ($head[0] < 0 || $head[0] >= 20 || $head[1] < 0 || $head[1] >= 20) {
    session_destroy();
    echo "Game Over! <a href='login.php'>Restart</a>";
    exit;
}

$_SESSION['snake'] = $snake;
?>

<meta http-equiv="refresh" content="0.4">

<link rel="stylesheet" href="style.css">

<h2>Score: <?= $_SESSION['score'] ?></h2>

<form method="POST">
    <button name="dir" value="UP">⬆</button>
    <button name="dir" value="LEFT">⬅</button>
    <button name="dir" value="RIGHT">➡</button>
    <button name="dir" value="DOWN">⬇</button>
</form>

<div class="board">
<?php
for ($y=0; $y<20; $y++) {
    for ($x=0; $x<20; $x++) {

        $isSnake = false;
        foreach ($snake as $part) {
            if ($part[0]==$x && $part[1]==$y) {
                $isSnake = true;
                break;
            }
        }

        if ($isSnake) {
            echo "<div class='snake'></div>";
        }
        elseif ($_SESSION['food'][0]==$x && $_SESSION['food'][1]==$y) {
            echo "<div class='food'></div>";
        }
        else {
            echo "<div class='cell'></div>";
        }
    }
}
?>
</div>

<a href="logout.php">Logout</a>

<?php if ($_SESSION['role'] === 'admin'): ?>
    | <a href="admin.php">Admin Panel</a>
<?php endif; ?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Snake</title>
    <link rel="stylesheet" href="style.css">
<script>
setInterval(function() {
    fetch("index.php?tick=1")
        .then(() => location.reload());
}, 500); // 500ms speed
</script>

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

