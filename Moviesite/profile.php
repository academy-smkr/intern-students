<?php
session_start();
require_once __DIR__ . '/config.php';

if(!isset($_SESSION['user_id']) || empty($_SESSION['user'])){
	header('Location: login.php');
	exit;
}

$userId = (int)$_SESSION['user_id'];
$currentUser = (string)$_SESSION['user'];
$errors = [];
$success = '';

// Cancel booking (only own booking)
if (isset($_POST['cancel_booking'])) {
	$bookingId = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;
	if ($bookingId > 0) {
		$del = $conn->prepare("DELETE FROM bookings WHERE id = ? AND user_id = ?");
		$del->bind_param("ii", $bookingId, $userId);
		$del->execute();
		$affected = $del->affected_rows;
		$del->close();
		if ($affected > 0) {
			$success = 'Booking canceled successfully.';
		} else {
			$errors[] = 'Could not cancel booking.';
		}
	}
}

// Update username
if (isset($_POST['update_profile'])) {
	$newUsername = trim($_POST['username'] ?? '');
	if ($newUsername === '') {
		$errors[] = 'Username is required.';
	} else {
		$check = $conn->prepare("SELECT id FROM users WHERE username = ? AND id <> ? LIMIT 1");
		$check->bind_param("si", $newUsername, $userId);
		$check->execute();
		$exists = $check->get_result()->fetch_assoc();
		$check->close();

		if ($exists) {
			$errors[] = 'Username is already taken.';
		} else {
			$upd = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
			$upd->bind_param("si", $newUsername, $userId);
			if ($upd->execute()) {
				$_SESSION['user'] = $newUsername;
				$currentUser = $newUsername;
				$success = 'Profile updated successfully.';
			} else {
				$errors[] = 'Profile update failed.';
			}
			$upd->close();
		}
	}
}

// Change password
if (isset($_POST['change_password'])) {
	$currentPassword = $_POST['current_password'] ?? '';
	$newPassword = $_POST['new_password'] ?? '';
	$confirmPassword = $_POST['confirm_password'] ?? '';

	if ($currentPassword === '' || $newPassword === '' || $confirmPassword === '') {
		$errors[] = 'All password fields are required.';
	} elseif (strlen($newPassword) < 6) {
		$errors[] = 'New password must be at least 6 characters.';
	} elseif (!hash_equals($newPassword, $confirmPassword)) {
		$errors[] = 'New password and confirm password do not match.';
	} else {
		$getUser = $conn->prepare("SELECT password FROM users WHERE id = ? LIMIT 1");
		$getUser->bind_param("i", $userId);
		$getUser->execute();
		$row = $getUser->get_result()->fetch_assoc();
		$getUser->close();

		$stored = (string)($row['password'] ?? '');
		$validCurrent = $stored !== '' && (password_verify($currentPassword, $stored) || hash_equals($stored, $currentPassword));

		if (!$validCurrent) {
			$errors[] = 'Current password is incorrect.';
		} else {
			$newHash = password_hash($newPassword, PASSWORD_DEFAULT);
			$updPw = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
			$updPw->bind_param("si", $newHash, $userId);
			if ($updPw->execute()) {
				$success = 'Password changed successfully.';
			} else {
				$errors[] = 'Password update failed.';
			}
			$updPw->close();
		}
	}
}

// Profile stats
$totalBookings = 0;
$totalSeats = 0;

$stats = $conn->prepare("SELECT COUNT(*) AS total_bookings, COALESCE(SUM(seats),0) AS total_seats FROM bookings WHERE user_id = ?");
$stats->bind_param("i", $userId);
$stats->execute();
$statRow = $stats->get_result()->fetch_assoc();
$stats->close();
if ($statRow) {
	$totalBookings = (int)$statRow['total_bookings'];
	$totalSeats = (int)$statRow['total_seats'];
}

// Booking history
$userBookings = [];
$stmt = $conn->prepare("
	SELECT b.id, b.seats, b.seat_labels, b.payment_method, b.booking_time, m.title AS movie_title
	FROM bookings b
	INNER JOIN movies m ON m.id = b.movie_id
	WHERE b.user_id = ?
	ORDER BY b.booking_time DESC, b.id DESC
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
	$userBookings[] = $row;
}
$stmt->close();
?>

<?php include __DIR__ . "/header.php"; ?>

<div class="container">
	<h2 style="margin-top:0">My Profile</h2>
	<p style="color:var(--muted);margin-top:0">Logged in as: <strong><?php echo htmlspecialchars($currentUser, ENT_QUOTES, 'UTF-8'); ?></strong></p>

	<?php if($success !== ''): ?>
		<div style="background:#12391f;color:#7df2a6;padding:10px;border-radius:8px;margin:10px 0;"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
	<?php endif; ?>
	<?php if(count($errors) > 0): ?>
		<div style="background:#3a1212;color:#ff9f9f;padding:10px;border-radius:8px;margin:10px 0;">
			<?php foreach($errors as $e): ?>
				<div><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;margin:16px 0 22px;">
		<div style="background:#151515;border:1px solid #2b2b2b;border-radius:10px;padding:14px;">
			<div style="color:#aaa;font-size:12px;">Total Bookings</div>
			<div style="font-size:28px;font-weight:700;"><?php echo $totalBookings; ?></div>
		</div>
		<div style="background:#151515;border:1px solid #2b2b2b;border-radius:10px;padding:14px;">
			<div style="color:#aaa;font-size:12px;">Total Seats Booked</div>
			<div style="font-size:28px;font-weight:700;"><?php echo $totalSeats; ?></div>
		</div>
	</div>

	<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:14px;margin-bottom:20px;">
		<div class="profile-card">
			<h3 style="margin-top:0;">Edit Profile</h3>
			<form method="POST">
				<input name="username" value="<?php echo htmlspecialchars($currentUser, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Username" required>
				<button type="submit" name="update_profile">Save Profile</button>
			</form>
		</div>

		<div class="profile-card">
			<h3 style="margin-top:0;">Change Password</h3>
			<form method="POST">
				<input name="current_password" type="password" placeholder="Current password" required>
				<input name="new_password" type="password" placeholder="New password" required>
				<input name="confirm_password" type="password" placeholder="Confirm new password" required>
				<button type="submit" name="change_password">Update Password</button>
			</form>
		</div>
	</div>

	<h3>My Bookings</h3>
	<?php if(count($userBookings) === 0): ?>
		<div class="profile-card" style="max-width:520px">
			<h3 style="margin:0 0 8px">No Bookings Yet</h3>
			<p style="margin:0;color:var(--muted)">You have not booked any movie yet.</p>
		</div>
	<?php else: ?>
		<table style="width:100%;border-collapse:collapse;color:#fff">
			<thead>
				<tr style="background:#1f1f1f;border-bottom:2px solid #e50914">
					<th style="padding:12px;text-align:left;border-right:1px solid #333">Movie</th>
					<th style="padding:12px;text-align:left;border-right:1px solid #333">Seats</th>
					<th style="padding:12px;text-align:left;border-right:1px solid #333">Seat Labels</th>
					<th style="padding:12px;text-align:left;border-right:1px solid #333">Payment</th>
					<th style="padding:12px;text-align:left;border-right:1px solid #333">Booked At</th>
					<th style="padding:12px;text-align:left">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($userBookings as $b): ?>
					<tr style="border-bottom:1px solid #333">
						<td style="padding:12px;border-right:1px solid #333"><?php echo htmlspecialchars((string)$b['movie_title'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td style="padding:12px;border-right:1px solid #333"><?php echo max(1, (int)$b['seats']); ?></td>
						<td style="padding:12px;border-right:1px solid #333"><?php echo htmlspecialchars((string)($b['seat_labels'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
						<td style="padding:12px;border-right:1px solid #333"><?php echo htmlspecialchars((string)$b['payment_method'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td style="padding:12px;border-right:1px solid #333"><?php echo htmlspecialchars((string)$b['booking_time'], ENT_QUOTES, 'UTF-8'); ?></td>
						<td style="padding:12px">
							<form method="POST" onsubmit="return confirm('Cancel this booking?');">
								<input type="hidden" name="booking_id" value="<?php echo (int)$b['id']; ?>">
								<button type="submit" name="cancel_booking" style="padding:6px 10px;border:none;border-radius:6px;background:#b91c1c;color:#fff;cursor:pointer">Cancel</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>

<?php include __DIR__ . "/footer.php"; ?>
