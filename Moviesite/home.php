<?php
session_start();
require_once __DIR__ . '/config.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['user'])) {
	header('Location: login.php');
	exit;
}

function home_resolve_image($imgPath, $title) {
	$imgPath = trim((string)$imgPath);
	$title = trim((string)$title);

	if ($imgPath !== '' && (preg_match('#^https?://#i', $imgPath) || strpos($imgPath, '//') === 0)) {
		return $imgPath;
	}

	$candidates = [];
	if ($imgPath !== '') {
		$candidates[] = $imgPath;
		$candidates[] = basename($imgPath);
		$candidates[] = 'images/' . basename($imgPath);
		$candidates[] = 'images/' . strtolower(basename($imgPath));
		$candidates[] = 'assets/' . basename($imgPath);
		$candidates[] = 'assets/' . strtolower(basename($imgPath));
	}

	if ($title !== '') {
		$clean = preg_replace('/[^A-Za-z0-9_-]/', '', strtolower($title));
		$candidates[] = 'images/' . $clean . '.jpg';
		$candidates[] = 'images/' . $clean . '.png';
		$candidates[] = 'assets/' . $clean . '.jpg';
		$candidates[] = 'assets/' . $clean . '.png';
	}

	foreach ($candidates as $cand) {
		if ($cand === '') {
			continue;
		}
		if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . $cand)) {
			return $cand;
		}
	}

	$label = $title !== '' ? rawurlencode($title) : 'No+Image';
	return 'https://via.placeholder.com/400x600?text=' . $label;
}

$search = trim($_GET['search'] ?? '');
$movies = [];

if ($search !== '') {
	$like = '%' . $search . '%';
	$stmt = $conn->prepare("SELECT id, title, image, price FROM movies WHERE title LIKE ? ORDER BY id DESC");
	$stmt->bind_param("s", $like);
	$stmt->execute();
	$res = $stmt->get_result();
	while ($row = $res->fetch_assoc()) {
		$movies[] = $row;
	}
	$stmt->close();
} else {
	$res = $conn->query("SELECT id, title, image, price FROM movies ORDER BY id DESC");
	if ($res) {
		while ($row = $res->fetch_assoc()) {
			$movies[] = $row;
		}
	}
}
?>

<?php include __DIR__ . "/header.php"; ?>

<div class="movies">
<?php foreach($movies as $m): ?>
	<?php
		$movieId = (int)($m['id'] ?? 0);
		$title = (string)($m['title'] ?? '');
		$price = is_numeric($m['price'] ?? null) ? (float)$m['price'] : 200.0;
		$imgSrc = home_resolve_image($m['image'] ?? '', $title);
	?>
	<div class="card">
		<div class="thumb" data-movie-id="<?php echo $movieId; ?>" data-price="<?php echo htmlspecialchars(number_format($price, 2, '.', ''), ENT_QUOTES, 'UTF-8'); ?>">
			<img src="<?php echo htmlspecialchars($imgSrc, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>">
			<div class="overlay"><button class="play">Book</button></div>
		</div>
		<div class="title"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></div>
		<div class="booking" style="display:none;margin-top:8px;text-align:center">
			<div style="margin-top:6px;color:var(--muted);font-size:13px">Choose seats and payment on next page</div>
			<div style="margin-top:12px;display:flex;gap:8px;justify-content:center">
				<button class="confirm-book" type="button" style="background:var(--accent);color:#fff;padding:8px 12px;border:none;border-radius:6px">Confirm Booking</button>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>

<?php include __DIR__ . "/footer.php"; ?>

<script>
document.addEventListener('click', function(e){
	if(e.target.matches('.play')){
		var card = e.target.closest('.card');
		var booking = card.querySelector('.booking');
		booking.style.display = booking.style.display === 'block' ? 'none' : 'block';
		return;
	}

	if(e.target.matches('.confirm-book')){
		var card = e.target.closest('.card');
		var thumb = card.querySelector('.thumb');
		var movieId = thumb ? thumb.getAttribute('data-movie-id') : '';
		if(movieId){
			window.location.href = 'booking.php?movie_id=' + encodeURIComponent(movieId);
		}
	}
});
</script>
