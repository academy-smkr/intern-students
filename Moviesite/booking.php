<?php
session_start();
require_once __DIR__ . '/config.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['user'])) {
	header('Location: login.php');
	exit;
}

$movieId = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : (int)($_POST['movie_id'] ?? 0);
if ($movieId <= 0) {
	header('Location: home.php');
	exit;
}

$stmt = $conn->prepare("SELECT id, title, image, price FROM movies WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $movieId);
$stmt->execute();
$movieRes = $stmt->get_result();
$movieData = $movieRes ? $movieRes->fetch_assoc() : null;
$stmt->close();

if (!$movieData) {
	header('Location: home.php');
	exit;
}

function booking_resolve_image($movieTitle, $movieImage) {
	$imgPath = trim((string)$movieImage);
	$title = trim((string)$movieTitle);

	$candidates = [];
	if($imgPath !== ''){
		$candidates[] = $imgPath;
		$candidates[] = basename($imgPath);
		$candidates[] = 'images/' . basename($imgPath);
		$candidates[] = 'images/' . strtolower(basename($imgPath));
		$candidates[] = 'assets/' . basename($imgPath);
		$candidates[] = 'assets/' . strtolower(basename($imgPath));
	}

	if($title !== ''){
		$clean = preg_replace('/[^A-Za-z0-9_-]/', '', strtolower($title));
		$candidates[] = 'images/' . $clean . '.jpg';
		$candidates[] = 'images/' . $clean . '.jpeg';
		$candidates[] = 'images/' . $clean . '.png';
		$candidates[] = 'assets/' . $clean . '.jpg';
		$candidates[] = 'assets/' . $clean . '.jpeg';
		$candidates[] = 'assets/' . $clean . '.png';
	}

	foreach($candidates as $cand){
		if($cand === ''){
			continue;
		}
		if(preg_match('#^https?://#i', $cand) || strpos($cand, '//') === 0){
			return $cand;
		}
		if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . $cand)){
			return $cand;
		}
	}

	$label = $title !== '' ? rawurlencode($title) : 'No+Image';
	return 'https://via.placeholder.com/400x600?text=' . $label;
}

$movieTitle = (string)$movieData['title'];
$imgSrc = booking_resolve_image($movieTitle, $movieData['image'] ?? '');
$ticketPrice = is_numeric($movieData['price'] ?? null) ? (float)$movieData['price'] : 200.0;

$bookingError = '';
$showSuccess = isset($_GET['success']) && $_GET['success'] === '1';
$letters = ['A','B','C','D','E'];
$numbers = [1,2,3,4,5,6,7,8,9,10];

if(isset($_POST['complete_booking'])){
	$chosenSeatsRaw = $_POST['seats'] ?? [];
	$paymentMethod = trim((string)($_POST['payment_method'] ?? ''));

	if(!is_array($chosenSeatsRaw)){
		$chosenSeatsRaw = [];
	}

	$validSeats = [];
	foreach($chosenSeatsRaw as $seat){
		$seatCode = strtoupper(trim((string)$seat));
		if(preg_match('/^(10|[1-9])[A-E]$/', $seatCode)){
			$validSeats[] = $seatCode;
		}
	}
	$validSeats = array_values(array_unique($validSeats));

	$allowedMethods = ['Online', 'Counter'];
	if(count($validSeats) < 1){
		$bookingError = 'Please select at least 1 seat.';
	} elseif(!in_array($paymentMethod, $allowedMethods, true)){
		$bookingError = 'Please choose a valid payment method.';
	} else {
		$userId = (int)$_SESSION['user_id'];
		$seatCount = count($validSeats);
		$seatLabels = implode(', ', $validSeats);
		$ins = $conn->prepare("INSERT INTO bookings (user_id, movie_id, seats, seat_labels, payment_method, booking_time) VALUES (?, ?, ?, ?, ?, NOW())");
		$ins->bind_param("iiiss", $userId, $movieId, $seatCount, $seatLabels, $paymentMethod);
		if ($ins->execute()) {
			$ins->close();
			header('Location: booking.php?movie_id=' . $movieId . '&success=1');
			exit;
		}
		$ins->close();
		$bookingError = 'Booking failed. Please try again.';
	}
}
?>

<?php include __DIR__ . "/header.php"; ?>

<div class="container booking-page">
	<h2 style="margin-top:0">Booking: <?php echo htmlspecialchars($movieTitle, ENT_QUOTES, 'UTF-8'); ?></h2>

	<div class="booking-layout">
		<form method="POST" class="seat-picker-box">
			<input type="hidden" name="movie_id" value="<?php echo $movieId; ?>">

			<?php if($bookingError !== ''): ?>
				<div class="booking-error"><?php echo htmlspecialchars($bookingError, ENT_QUOTES, 'UTF-8'); ?></div>
			<?php endif; ?>

			<div class="seat-grid-title">Select Seats (50 total)</div>
			<div class="seat-grid-subtitle">10 horizontal (1-10) and 5 vertical (A-E)</div>

			<div class="seat-grid-body">
				<?php foreach($letters as $letter): ?>
					<div class="seat-row-label"><?php echo $letter; ?></div>
					<?php foreach($numbers as $n): ?>
						<?php $seatCode = $n . $letter; ?>
						<label class="seat-cell" title="Seat <?php echo htmlspecialchars($seatCode, ENT_QUOTES, 'UTF-8'); ?>">
							<input type="checkbox" name="seats[]" value="<?php echo htmlspecialchars($seatCode, ENT_QUOTES, 'UTF-8'); ?>" class="seat-checkbox">
							<span><?php echo htmlspecialchars($seatCode, ENT_QUOTES, 'UTF-8'); ?></span>
						</label>
					<?php endforeach; ?>
				<?php endforeach; ?>
			</div>

			<div class="booking-summary">
				<div>Selected seats: <strong id="selectedSeatCount">0</strong></div>
				<div>Total: ₹<strong id="bookingTotal">0.00</strong></div>
			</div>

			<div class="payment-wrap">
				<div class="pay-title">Payment Method</div>
				<label class="pay-option"><input type="radio" name="payment_method" value="Online" required><span>Online Pay</span></label>
				<label class="pay-option"><input type="radio" name="payment_method" value="Counter" required><span>Pay at Counter</span></label>
			</div>

			<button type="submit" name="complete_booking" class="complete-booking-btn">Complete Booking</button>
		</form>
	</div>
</div>

<div id="bookingSuccessPopup" class="booking-success-popup" style="<?php echo $showSuccess ? 'display:block' : 'display:none'; ?>">
	<div class="booking-success-text">booking successfull</div>
</div>

<script>
(function(){
	var checks = document.querySelectorAll('.seat-checkbox');
	var countEl = document.getElementById('selectedSeatCount');
	var totalEl = document.getElementById('bookingTotal');
	var unitPrice = <?php echo json_encode((float)$ticketPrice); ?>;
	var showSuccess = <?php echo $showSuccess ? 'true' : 'false'; ?>;

	function updateBookingSummary(){
		var count = 0;
		checks.forEach(function(chk){
			if(chk.checked){ count++; }
		});
		countEl.textContent = String(count);
		totalEl.textContent = (count * unitPrice).toFixed(2);
	}

	checks.forEach(function(chk){
		chk.addEventListener('change', updateBookingSummary);
	});

	updateBookingSummary();

	if(showSuccess){
		var popup = document.getElementById('bookingSuccessPopup');
		if(popup){
			setTimeout(function(){
				window.location.href = 'home.php';
			}, 3000);
		}
	}
})();
</script>

<?php include __DIR__ . "/footer.php"; ?>
