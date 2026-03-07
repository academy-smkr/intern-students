<?php
session_start();
require_once __DIR__ . '/config.php';

if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
    header('Location: admin.php');
    exit;
}

$error = '';
if(isset($_POST['login'])){
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';

    if ($u === '' || $p === '') {
        $error = 'Username and password are required';
    } else {
        $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $u);
        $stmt->execute();
        $res = $stmt->get_result();
        $admin = $res ? $res->fetch_assoc() : null;
        $stmt->close();

        $isValid = false;
        if ($admin) {
            $isValid = password_verify($p, $admin['password']) || hash_equals((string)$admin['password'], $p);
        }

        if ($isValid) {
        session_regenerate_id(true);
        $_SESSION['is_admin'] = true;
        $_SESSION['admin_id'] = (int)$admin['id'];
        $_SESSION['admin_username'] = (string)$admin['username'];
        header('Location: admin.php');
        exit;
        } else {
        $error = 'Invalid admin password';
        }
    }
}
?>

<?php $pageClass = 'auth-page'; $hideSearch = true; ?>
<?php include __DIR__ . '/header.php'; ?>

<section class="auth-shell">
    <div class="auth-box auth-box-creative">
        <div class="auth-panel">
            <?php if(!empty($error)): ?><div class="auth-error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
            <form method="POST" class="auth-form">
                <input name="username" placeholder="Admin username" required>
                <input name="password" type="password" placeholder="Admin password" required>
                <button name="login">Login</button>
            </form>
        </div>
    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
