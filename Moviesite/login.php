<?php
session_start();
require_once __DIR__ . '/config.php';

if (isset($_SESSION['user_id']) && !empty($_SESSION['user'])) {
	header("Location: home.php");
	exit;
}

$error = '';

if(isset($_POST['login'])){
	$u = trim($_POST['username'] ?? '');
	$p = $_POST['password'] ?? '';

	if ($u === '' || $p === '') {
		$error = "Username and password are required";
	} else {
		$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? LIMIT 1");
		$stmt->bind_param("s", $u);
		$stmt->execute();
		$res = $stmt->get_result();
		$user = $res ? $res->fetch_assoc() : null;
		$stmt->close();

		$isValid = false;
		if ($user) {
			// Support both hashed and plain passwords.
			$isValid = password_verify($p, $user['password']) || hash_equals((string)$user['password'], $p);
		}

		if($isValid){
			session_regenerate_id(true);
			$_SESSION['user_id'] = (int)$user['id'];
			$_SESSION['user'] = (string)$user['username'];
			unset($_SESSION['is_admin'], $_SESSION['admin_id'], $_SESSION['admin_username']);
			header("Location: home.php");
			exit;
		}else{
			$error = "Invalid login";
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
				<button name="login">Sign In</button>
			</form>
			<p class="auth-foot">New here? <a href="register.php">Create account</a></p>
		</div>
	</div>
</section>

<?php include __DIR__."/footer.php"; ?>
