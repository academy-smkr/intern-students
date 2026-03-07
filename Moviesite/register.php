<?php
session_start();
require_once __DIR__ . '/config.php';

$error = '';

if (isset($_SESSION['user_id']) && !empty($_SESSION['user'])) {
	header("Location: home.php");
	exit;
}

if(isset($_POST['register'])){
	$u = trim($_POST['username'] ?? '');
	$p = $_POST['password'] ?? '';

	if ($u === '' || $p === '') {
		$error = 'Username and password are required.';
	} else {
		$check = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
		$check->bind_param("s", $u);
		$check->execute();
		$exists = $check->get_result()->fetch_assoc();
		$check->close();

		if ($exists) {
			$error = 'Username already exists.';
		} else {
			$hashed = password_hash($p, PASSWORD_DEFAULT);
			$ins = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
			$ins->bind_param("ss", $u, $hashed);
			if ($ins->execute()) {
				$ins->close();
				header("Location: login.php");
				exit;
			}
			$ins->close();
			$error = 'Registration failed. Please try again.';
		}
	}
}
?>

<?php $pageClass = 'auth-page'; $hideSearch = true; ?>
<?php include __DIR__."/header.php"; ?>

<section class="auth-shell">
	<div class="auth-box auth-box-creative">
		<div class="auth-panel">
			<?php if(!empty($error)): ?><div class="auth-error"><?php echo htmlspecialchars($error,ENT_QUOTES,'UTF-8'); ?></div><?php endif; ?>
			<form method="POST" class="auth-form">
				<input name="username" placeholder="Enter username" required>
				<input name="password" type="password" placeholder="Enter password" required>
				<button name="register">Create Account</button>
			</form>
			<p class="auth-foot">Already have an account? <a href="login.php">Login</a></p>
		</div>
	</div>
</section>

<?php include __DIR__."/footer.php"; ?>
