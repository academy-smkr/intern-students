<?php
session_start();
require_once __DIR__ . '/config.php';

if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true){
	header('Location: admin_login.php');
	exit;
}

$defaultPrice = 0.0;
$addError = '';

// ADD MOVIE
if(isset($_POST['add'])){
	$title = trim($_POST['title'] ?? '');
	$image = '';
	$priceRaw = trim((string)($_POST['price'] ?? ''));
	$price = $defaultPrice;
	if ($priceRaw === '') {
		$addError = 'Please enter movie price.';
	} else {
		$price = floatval($priceRaw);
	}

	if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK){
		$originalName = basename($_FILES['image_file']['name'] ?? '');
		$ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
		if(in_array($ext, ['jpg', 'jpeg'], true)){
			$base = pathinfo($originalName, PATHINFO_FILENAME);
			$base = preg_replace('/[^A-Za-z0-9_-]/', '_', (string)$base);
			if($base === ''){ $base = 'movie'; }
			$unique = str_replace('.', '_', uniqid('', true));
			$fileName = $base . '_' . $unique . '.' . $ext;
			$targetRel = 'images/' . $fileName;
			$targetAbs = __DIR__ . DIRECTORY_SEPARATOR . $targetRel;

			if(move_uploaded_file($_FILES['image_file']['tmp_name'], $targetAbs)){
				$image = $targetRel;
			} else {
				$addError = 'Image upload failed. Please try again.';
			}
		} else {
			$addError = 'Please upload a JPG/JPEG image.';
		}
	} else {
		$addError = 'Please select a JPG image file.';
	}

	if($title !== '' && $image !== ''){
		$ins = $conn->prepare("INSERT INTO movies (title, image, price) VALUES (?, ?, ?)");
		$ins->bind_param("ssd", $title, $image, $price);
		if (!$ins->execute()) {
			$addError = 'Could not save movie to database.';
		}
		$ins->close();
	}
}

// REMOVE MOVIE
if(isset($_POST['delete_movie_id'])){
	$movieId = (int)$_POST['delete_movie_id'];
	if ($movieId > 0) {
		$del = $conn->prepare("DELETE FROM movies WHERE id = ?");
		$del->bind_param("i", $movieId);
		$del->execute();
		$del->close();
	}
}

// EDIT MOVIE
if(isset($_POST['save_edit'])){
	$movieId = isset($_POST['movie_id']) ? (int)$_POST['movie_id'] : 0;
	$title = trim($_POST['title'] ?? '');
	$image = trim($_POST['image'] ?? '');
	$price = isset($_POST['price']) && $_POST['price'] !== '' ? floatval($_POST['price']) : $defaultPrice;
	if($movieId > 0 && $title !== ''){
		$upd = $conn->prepare("UPDATE movies SET title = ?, image = ?, price = ? WHERE id = ?");
		$upd->bind_param("ssdi", $title, $image, $price, $movieId);
		$upd->execute();
		$upd->close();
	}
}

// REMOVE BOOKING
if(isset($_POST['delete_booking_id'])){
	$bookingId = (int)$_POST['delete_booking_id'];
	if ($bookingId > 0) {
		$delB = $conn->prepare("DELETE FROM bookings WHERE id = ?");
		$delB->bind_param("i", $bookingId);
		$delB->execute();
		$delB->close();
	}
}

// EDIT BOOKING
if(isset($_POST['save_booking_edit'])){
	$bookingId = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;
	$seats = isset($_POST['booking_seats']) ? (int)$_POST['booking_seats'] : 1;
	$method = trim($_POST['booking_method'] ?? '');
	if ($seats < 1) { $seats = 1; }
	if ($bookingId > 0 && in_array($method, ['Online', 'Counter'], true)) {
		$updB = $conn->prepare("UPDATE bookings SET seats = ?, payment_method = ? WHERE id = ?");
		$updB->bind_param("isi", $seats, $method, $bookingId);
		$updB->execute();
		$updB->close();
	}
}

function admin_resolve_image($imgRaw, $title) {
	$imgRawTrim = trim((string)$imgRaw);
	$title = trim((string)$title);

	if (preg_match('#^https?://#i', $imgRawTrim) || strpos($imgRawTrim, '//') === 0) {
		return $imgRawTrim;
	}

	$cands = [];
	if($imgRawTrim !== ''){
		$cands[] = $imgRawTrim;
		$cands[] = basename($imgRawTrim);
		$cands[] = 'images/' . basename($imgRawTrim);
		$cands[] = 'images/' . strtolower(basename($imgRawTrim));
		$cands[] = 'assets/' . basename($imgRawTrim);
		$cands[] = 'assets/' . strtolower(basename($imgRawTrim));
	}

	$clean = preg_replace('/[^A-Za-z0-9_-]/','', strtolower($title));
	$cands[] = 'images/' . $clean . '.jpg';
	$cands[] = 'images/' . $clean . '.png';
	$cands[] = 'assets/' . $clean . '.jpg';
	$cands[] = 'assets/' . $clean . '.png';

	foreach($cands as $c){
		if($c !== '' && file_exists(__DIR__ . DIRECTORY_SEPARATOR . $c)){
			return $c;
		}
	}

	$label = $title ? rawurlencode($title) : 'No+Image';
	return 'https://via.placeholder.com/400x600?text=' . $label;
}

$movies = [];
$movieRes = $conn->query("SELECT id, title, image, price FROM movies ORDER BY id DESC");
if ($movieRes) {
	while ($row = $movieRes->fetch_assoc()) {
		$movies[] = $row;
	}
}
$total = count($movies);

$bookings = [];
$bookingRes = $conn->query("
	SELECT b.id, u.username, m.title AS movie_title, b.seats, b.payment_method
	FROM bookings b
	INNER JOIN users u ON u.id = b.user_id
	INNER JOIN movies m ON m.id = b.movie_id
	ORDER BY b.id DESC
");
if ($bookingRes) {
	while ($row = $bookingRes->fetch_assoc()) {
		$bookings[] = $row;
	}
}
?>

<?php include __DIR__."/header.php"; ?>

<section class="admin-shell">
	<div class="admin-panel">
		<div class="admin-panel-top">
			<h2>Admin Panel</h2>
			<p>Total Movies: <b><?php echo $total; ?></b></p>
		</div>

		<h3 class="admin-section-title">Add Movie</h3>
		<?php if($addError): ?><div class="admin-alert"><?php echo htmlspecialchars($addError, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
	<form method="POST" enctype="multipart/form-data" class="admin-add-form">
			<div class="admin-field">
				<label for="movie-title">Movie Title</label>
				<input id="movie-title" name="title" placeholder="Enter movie title" required>
			</div>
			<div class="admin-field">
				<label for="movie-image">Poster (JPG/JPEG)</label>
				<input id="movie-image" name="image_file" type="file" accept=".jpg,.jpeg,image/jpeg" required>
			</div>
			<div class="admin-field">
				<label for="movie-price">Ticket Price</label>
				<input id="movie-price" name="price" type="number" step="0.01" min="0" placeholder="Enter ticket price" required>
			</div>
			<div class="admin-add-actions">
				<button name="add">Add Movie</button>
			</div>
		</form>
	</div>
</section>

<div class="container">
	<h3 class="admin-section-title">Manage Movies</h3>
	<div class="admin-movies-list">
	<?php foreach($movies as $m): ?>
		<?php
			$movieId = (int)$m['id'];
			$title = htmlspecialchars((string)$m['title'], ENT_QUOTES, 'UTF-8');
			$rawImage = (string)($m['image'] ?? '');
			$resolved = admin_resolve_image($rawImage, (string)$m['title']);
		?>
		<div class="card">
			<div class="thumb" data-id="<?php echo $movieId; ?>" data-price="<?php echo htmlspecialchars(number_format((float)($m['price'] ?? $defaultPrice),2,'.',''), ENT_QUOTES, 'UTF-8'); ?>">
				<img src="<?php echo htmlspecialchars($resolved, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo $title; ?>">
				<div class="overlay"><button class="play">Book</button></div>
			</div>
			<div class="title"><?php echo $title; ?></div>
			<div class="admin-price" style="text-align:center;color:var(--muted);margin-top:6px">Price: ₹<?php echo number_format((float)($m['price'] ?? $defaultPrice),2); ?></div>
			<form method="POST" class="remove-form" onsubmit="return confirm('Remove <?php echo addslashes((string)$m['title']); ?>?')">
				<input type="hidden" name="delete_movie_id" value="<?php echo $movieId; ?>">
				<button type="submit" class="remove-btn">Remove</button>
			</form>
			<button class="edit-btn" data-id="<?php echo $movieId; ?>">Edit</button>

			<form method="POST" class="edit-form" id="edit-form-<?php echo $movieId; ?>">
				<input type="hidden" name="movie_id" value="<?php echo $movieId; ?>">
				<input name="title" value="<?php echo $title; ?>" placeholder="Movie title" required>
				<input name="image" value="<?php echo htmlspecialchars($rawImage, ENT_QUOTES,'UTF-8'); ?>" placeholder="Image URL or assets/..." required>
				<input name="price" type="number" step="0.01" value="<?php echo htmlspecialchars(number_format((float)($m['price'] ?? $defaultPrice),2,'.',''), ENT_QUOTES,'UTF-8'); ?>" placeholder="Price">
				<div style="display:flex;gap:8px">
					<button type="submit" name="save_edit">Save</button>
					<button type="button" class="cancel-edit" data-id="<?php echo $movieId; ?>">Cancel</button>
				</div>
			</form>
		</div>
	<?php endforeach; ?>
	</div>
</div>

<div class="container">
	<h3>Bookings</h3>
	<table style="width:100%;border-collapse:collapse;color:#fff">
		<thead>
			<tr style="background:#1f1f1f;border-bottom:2px solid #e50914">
				<th style="padding:12px;text-align:left;border-right:1px solid #333">Name</th>
				<th style="padding:12px;text-align:left;border-right:1px solid #333">Movie</th>
				<th style="padding:12px;text-align:left;border-right:1px solid #333">No. Seats</th>
				<th style="padding:12px;text-align:left;border-right:1px solid #333">Payment Method</th>
				<th style="padding:12px;text-align:left">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if(count($bookings) > 0): ?>
				<?php foreach($bookings as $b): ?>
					<?php $bookingId = (int)$b['id']; ?>
					<tr style="border-bottom:1px solid #333">
						<td style="padding:12px;border-right:1px solid #333"><?php echo htmlspecialchars((string)$b['username'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td style="padding:12px;border-right:1px solid #333"><?php echo htmlspecialchars((string)$b['movie_title'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td style="padding:12px;border-right:1px solid #333"><?php echo (int)$b['seats']; ?></td>
						<td style="padding:12px;border-right:1px solid #333"><?php echo htmlspecialchars((string)$b['payment_method'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td style="padding:12px">
							<button type="button" class="edit-booking-btn" data-id="<?php echo $bookingId; ?>" style="margin-right:8px;padding:6px 10px;border:none;border-radius:6px;background:#06b;color:#fff;cursor:pointer">Edit</button>
							<form method="POST" style="display:inline" onsubmit="return confirm('Remove this booking?')">
								<input type="hidden" name="delete_booking_id" value="<?php echo $bookingId; ?>">
								<button type="submit" style="padding:6px 10px;border:none;border-radius:6px;background:#b91c1c;color:#fff;cursor:pointer">Remove</button>
							</form>
						</td>
					</tr>
					<tr id="booking-edit-row-<?php echo $bookingId; ?>" style="display:none;background:#111;border-bottom:1px solid #333">
						<td colspan="5" style="padding:12px">
							<form method="POST" style="display:grid;grid-template-columns:120px 180px auto;gap:8px;align-items:center">
								<input type="hidden" name="booking_id" value="<?php echo $bookingId; ?>">
								<input name="booking_seats" type="number" min="1" value="<?php echo (int)($b['seats'] ?? 1); ?>" placeholder="Seats" required style="padding:8px;border-radius:6px;border:1px solid #333;background:#0f0f0f;color:#fff">
								<select name="booking_method" required style="padding:8px;border-radius:6px;border:1px solid #333;background:#0f0f0f;color:#fff">
									<option value="Online" <?php echo ((string)$b['payment_method'] === 'Online') ? 'selected' : ''; ?>>Online</option>
									<option value="Counter" <?php echo ((string)$b['payment_method'] === 'Counter') ? 'selected' : ''; ?>>Counter</option>
								</select>
								<div style="display:flex;gap:8px;justify-content:flex-end">
									<button type="submit" name="save_booking_edit" style="padding:8px 10px;border:none;border-radius:6px;background:#16a34a;color:#fff;cursor:pointer">Save</button>
									<button type="button" class="cancel-booking-edit" data-id="<?php echo $bookingId; ?>" style="padding:8px 10px;border:none;border-radius:6px;background:#444;color:#fff;cursor:pointer">Cancel</button>
								</div>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="5" style="padding:12px;text-align:center;color:#999">No bookings yet</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<?php include __DIR__."/footer.php"; ?>

<script>
document.addEventListener('click', function(e){
	if(e.target.matches('.edit-btn')){
		var id = e.target.getAttribute('data-id');
		var form = document.getElementById('edit-form-' + id);
		if(form) form.style.display = form.style.display === 'block' ? 'none' : 'block';
	}
	if(e.target.matches('.cancel-edit')){
		var id = e.target.getAttribute('data-id');
		var form = document.getElementById('edit-form-' + id);
		if(form) form.style.display = 'none';
	}
	if(e.target.matches('.edit-booking-btn')){
		var bookingId = e.target.getAttribute('data-id');
		var row = document.getElementById('booking-edit-row-' + bookingId);
		if(row) row.style.display = row.style.display === 'table-row' ? 'none' : 'table-row';
	}
	if(e.target.matches('.cancel-booking-edit')){
		var bookingId = e.target.getAttribute('data-id');
		var row = document.getElementById('booking-edit-row-' + bookingId);
		if(row) row.style.display = 'none';
	}
});
</script>
