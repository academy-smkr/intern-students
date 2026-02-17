<?php
session_start();

// Login check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['restart'])) {
    unset($_SESSION['snake'], $_SESSION['direction'], $_SESSION['food'], $_SESSION['score']);
    header("Location: index.php");
    exit;
}

$gridSize = 20;
$gameOver = false;
$allowed = ['UP', 'DOWN', 'LEFT', 'RIGHT'];

// Initialize game
if (!isset($_SESSION['snake'])) {
    $center = intdiv($gridSize, 2);
    $_SESSION['snake'] = [
        [$center, $center],
        [$center - 1, $center],
        [$center - 2, $center]
    ];
    $_SESSION['direction'] = 'RIGHT';
    $_SESSION['food'] = [rand(0, $gridSize - 1), rand(0, $gridSize - 1)];
    $_SESSION['score'] = 0;
}

function nextHeadForDirection(array $head, string $direction): array {
    switch ($direction) {
        case 'UP':    $head[1]--; break;
        case 'DOWN':  $head[1]++; break;
        case 'LEFT':  $head[0]--; break;
        case 'RIGHT': $head[0]++; break;
    }
    return $head;
}

function isOutOfBounds(array $cell, int $gridSize): bool {
    return $cell[0] < 0 || $cell[0] >= $gridSize || $cell[1] < 0 || $cell[1] >= $gridSize;
}

function hitsSnake(array $nextHead, array $snake, array $food): bool {
    $willEat = ($nextHead[0] === $food[0] && $nextHead[1] === $food[1]);
    $body = $snake;

    if (!$willEat) {
        array_pop($body);
    }

    foreach ($body as $part) {
        if ($part[0] === $nextHead[0] && $part[1] === $nextHead[1]) {
            return true;
        }
    }

    return false;
}

function isSafeMove(string $direction, array $head, array $snake, array $food, int $gridSize): bool {
    $nextHead = nextHeadForDirection($head, $direction);
    if (isOutOfBounds($nextHead, $gridSize)) {
        return false;
    }
    return !hitsSnake($nextHead, $snake, $food);
}

// Change preferred direction from controls/keys
if (isset($_POST['dir']) && in_array($_POST['dir'], $allowed, true)) {
    $_SESSION['direction'] = $_POST['dir'];
}

$snake = $_SESSION['snake'];
$head = $snake[0];
$food = $_SESSION['food'];

$currentDirection = $_SESSION['direction'];
$nextHead = nextHeadForDirection($head, $currentDirection);

if (isOutOfBounds($nextHead, $gridSize)) {
    $gameOver = true;
} else {
    $chosenDirection = $currentDirection;

    if (hitsSnake($nextHead, $snake, $food)) {
        $chosenDirection = null;
        foreach ($allowed as $dir) {
            if ($dir === $currentDirection) {
                continue;
            }
            if (isSafeMove($dir, $head, $snake, $food, $gridSize)) {
                $chosenDirection = $dir;
                break;
            }
        }
    }
}

if (!isset($chosenDirection) || $chosenDirection === null) {
    $gameOver = true;
} else {
    $_SESSION['direction'] = $chosenDirection;
    $head = nextHeadForDirection($head, $chosenDirection);

    // Add new head
    array_unshift($snake, $head);

    // Food check
    if ($head[0] === $food[0] && $head[1] === $food[1]) {
        $_SESSION['score']++;
        $_SESSION['food'] = [rand(0, $gridSize - 1), rand(0, $gridSize - 1)];
    } else {
        array_pop($snake);
    }

    $_SESSION['snake'] = $snake;
}

$score = $_SESSION['score'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Snake Game</title>
    <style>
        :root {
            --bg: #050b05;
            --panel: #0b180b;
            --grid-line: #193119;
            --text: #8cff72;
            --snake: #59ff3e;
            --snake-head: #b9ff53;
            --food: #ff3b2f;
            --danger: #ff0000;
        }
        body {
            text-align: center;
            background:
                radial-gradient(circle at 20% 10%, #123512 0%, transparent 35%),
                radial-gradient(circle at 80% 90%, #0f280f 0%, transparent 30%),
                repeating-linear-gradient(
                    0deg,
                    rgba(120, 255, 120, 0.03) 0px,
                    rgba(120, 255, 120, 0.03) 2px,
                    transparent 2px,
                    transparent 4px
                ),
                var(--bg);
            color: var(--text);
            font-family: "Courier New", "Lucida Console", monospace;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .game-shell {
            width: min(92vw, 760px);
            background: var(--panel);
            border: 3px solid #2b5f2b;
            box-shadow: 0 0 24px rgba(116, 255, 105, 0.2), inset 0 0 30px rgba(18, 68, 18, 0.4);
            border-radius: 10px;
            padding: 20px;
        }
        h2 {
            margin: 0 0 14px 0;
            font-size: 28px;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-shadow: 0 0 8px rgba(106, 255, 93, 0.65);
        }
        .grid {
            display: inline-grid;
            grid-template-columns: repeat(20, 25px);
            width: 500px;
            margin: 20px auto 12px;
            border: 2px solid #2f6a2f;
            box-shadow: 0 0 15px rgba(77, 255, 63, 0.25);
        }
        .cell {
            width: 25px;
            height: 25px;
            border: 1px solid var(--grid-line);
            box-sizing: border-box;
        }
        .snake {
            background: var(--snake);
            box-shadow: inset 0 0 6px rgba(12, 71, 7, 0.45);
        }
        .food {
            background: var(--food);
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(255, 59, 47, 0.7);
            animation: pulse 0.8s infinite alternate;
        }
        @keyframes pulse {
            from { transform: scale(0.82); }
            to { transform: scale(1); }
        }
        .controls {
            margin-top: 10px;
        }
        .controls button {
            width: 44px;
            height: 44px;
            background: #102510;
            color: var(--text);
            border: 2px solid #326932;
            font-size: 22px;
            cursor: pointer;
            box-shadow: 0 0 8px rgba(115, 255, 80, 0.2);
        }
        .controls button:hover {
            background: #163216;
        }
        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.82);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        .popup {
            background: #1b0505;
            border: 6px solid var(--danger);
            color: var(--danger);
            font-size: 88px;
            font-weight: 900;
            letter-spacing: 4px;
            text-transform: uppercase;
            padding: 30px 50px;
            box-shadow: 0 0 30px rgba(255, 0, 0, 0.35);
        }
        .popup small {
            display: block;
            margin-top: 16px;
            font-size: 24px;
            letter-spacing: 1px;
            color: #ffd3d3;
            text-transform: none;
        }
        .actions {
            margin-top: 18px;
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .action-btn {
            display: inline-block;
            padding: 10px 16px;
            border: 2px solid #fff5f5;
            color: #fff5f5;
            text-decoration: none;
            font-size: 16px;
            background: rgba(255, 43, 43, 0.08);
            cursor: pointer;
        }
        .action-btn:hover {
            background: rgba(255, 70, 70, 0.2);
        }
    </style>
</head>
<body>
<div class="game-shell">
<h2>Score: <?= $score; ?></h2>

<div class="controls">
    <button type="button" onclick="setDirection('UP')">&#8593;</button><br>
    <button type="button" onclick="setDirection('LEFT')">&#8592;</button>
    <button type="button" onclick="setDirection('DOWN')">&#8595;</button>
    <button type="button" onclick="setDirection('RIGHT')">&#8594;</button>
</div>

<form id="tickForm" method="POST">
    <input type="hidden" name="dir" id="dirInput" value="">
</form>

<script>
const gameOver = <?= $gameOver ? "true" : "false"; ?>;
const keyToDir = {
    ArrowUp: "UP",
    ArrowDown: "DOWN",
    ArrowLeft: "LEFT",
    ArrowRight: "RIGHT",
    w: "UP",
    a: "LEFT",
    s: "DOWN",
    d: "RIGHT"
};

function setDirection(dir) {
    if (gameOver) return;
    const input = document.getElementById("dirInput");
    if (!input) return;
    input.value = dir;
}

document.addEventListener("keydown", function (event) {
    if (gameOver) return;

    const key = event.key.length === 1 ? event.key.toLowerCase() : event.key;
    const dir = keyToDir[key];
    if (!dir) return;

    event.preventDefault();
    setDirection(dir);
});

if (!gameOver) {
    setInterval(function () {
        const tickForm = document.getElementById("tickForm");
        if (!tickForm) return;
        tickForm.submit();
    }, 500);
}
</script>

<div class="grid">
<?php
for ($y = 0; $y < $gridSize; $y++) {
    for ($x = 0; $x < $gridSize; $x++) {

        $class = "cell";

        foreach ($snake as $part) {
            if ($part[0] == $x && $part[1] == $y) {
                $class .= " snake";
            }
        }

        if ($_SESSION['food'][0] == $x && $_SESSION['food'][1] == $y) {
            $class .= " food";
        }

        echo "<div class='$class'></div>";
    }
}
?>
</div>
</div>

<?php if ($gameOver): ?>
<div class="overlay">
    <div class="popup">
        Game Over
        <small>Your score: <?= $score; ?></small>
        <div class="actions">
            <a class="action-btn" href="save_score.php">Save Score & View Scoreboard</a>
            <a class="action-btn" href="leaderboard.php">View Scoreboard</a>
            <form method="POST" style="display:inline;">
                <button class="action-btn" type="submit" name="restart" value="1">Play Again</button>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

</body>
</html>
