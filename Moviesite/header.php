<?php
if(session_status()===PHP_SESSION_NONE) session_start();
$currentPage = basename($_SERVER['PHP_SELF'] ?? '');
$showSearch = in_array($currentPage, ['home.php', 'admin.php'], true);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Movies</title>
  <link rel="stylesheet" href="style.css">
</head>
<?php $bodyClass = isset($pageClass) && $pageClass !== '' ? ' class="' . htmlspecialchars($pageClass, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>
<body<?php echo $bodyClass; ?>>
  <header class="site-header">
    <div class="logo"><a href="home.php">TicketFlix</a></div>
    <?php if($showSearch): ?>
      <div class="search-area">
        <?php include __DIR__."/searchbar.php"; ?>
      </div>
    <?php endif; ?>
    <div class="user-nav">
      <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
        <a href="logout.php">Logout</a>
      <?php elseif(isset($_SESSION['user']) && $_SESSION['user']): ?>
        <a class="profile-link" href="profile.php"><?php echo htmlspecialchars($_SESSION['user'],ENT_QUOTES,'UTF-8'); ?></a>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
      <?php endif; ?>
    </div>
  </header>

  <main class="container">
