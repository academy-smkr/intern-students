<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$result = $conn->query("
    SELECT
        users.username,
        scores.score,
        (
            SELECT MAX(s2.score)
            FROM scores s2
            WHERE s2.user_id = scores.user_id
        ) AS high_score,
        scores.created_at
    FROM scores
    JOIN users ON scores.user_id = users.id
    ORDER BY scores.score DESC, scores.created_at DESC
");
?>

<link rel="stylesheet" href="style.css">

<body class="leaderboard-body">
<div class="container">
<h1>Leaderboard</h1>

<table>
<tr><th>User</th><th>Score</th><th>High Score</th><th>Date Time</th></tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
<td><?php echo $row['username']; ?></td>
<td><?php echo $row['score']; ?></td>
<td><?php echo $row['high_score']; ?></td>
<td><?php echo date("Y-m-d H:i:s", strtotime($row['created_at'])); ?></td>
</tr>
<?php } ?>
</table>

<a href="index.php">Back to Game</a>
</div>
</body>

