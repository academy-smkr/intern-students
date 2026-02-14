<?php
include 'db.php';

$result = $conn->query("
    SELECT users.username, scores.score, scores.created_at
    FROM scores
    JOIN users ON scores.user_id = users.id
    ORDER BY score DESC
");
?>

<link rel="stylesheet" href="style.css">

<div class="container">
<h1>Leaderboard</h1>

<table>
<tr><th>User</th><th>Score</th><th>Date</th></tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
<td><?php echo $row['username']; ?></td>
<td><?php echo $row['score']; ?></td>
<td><?php echo $row['created_at']; ?></td>
</tr>
<?php } ?>
</table>

<a href="login.php">Back to Login</a>
</div>

