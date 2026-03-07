<form class="search-form" method="GET" action="home.php">
	<input type="text" name="search" placeholder="Search movies..." value="<?php echo htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES,'UTF-8'); ?>">
	<button type="submit">Search</button>
</form>