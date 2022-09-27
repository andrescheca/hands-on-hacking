<?php
session_start();
// If a session is empty then redirect to the login.php page
if (empty($_SESSION['user'])) {
	header("Location: /login.php");
}

try {
	$mysqli = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']);
	// Check connection
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
		exit();
	}
} catch (Exception $e) {
	echo "Error: " . $e->getMessage() . "<br/>" . "Please try again in a few minutes, the database is being created right now.";
	exit();
}
$message = isset($_GET['message']) ? $_GET['message'] : "";
$users = [];
$balance = 0;
$user = '';

try {
	$query = "SELECT * FROM users WHERE username = '$_SESSION[user]' LIMIT 1";

	$stmt = $mysqli->prepare($query);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$user = $row['name'];
		$balance = $row['balance'];
	}

	// Select all users except the current logged in user.
	$query = "SELECT * FROM users WHERE username != '$_SESSION[user]'";
	$stmt = $mysqli->prepare($query);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$users[] = $row;
		}
	}
} catch (Exception $e) {
	echo "Error: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">

<head>
	<link href="/css/main.css" rel="stylesheet">
</head>

<body class="h-full">
	<div class="min-h-full flex flex-col">
		<nav class="bg-white border-b border-gray-200">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="justify-between h-16 hidden sm:flex">
					<div class="flex">
						<div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
							<a href="#" class="border-blue-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium" aria-current="page"> Transfer </a>
							<a href="/settings.php" class="text-gray-500 inline-flex items-center px-1 pt-1 text-sm font-medium"> Settings </a>
						</div>
					</div>
					<div class="hidden sm:ml-6 sm:flex sm:items-center">
						<a href="/logout.php" class="border-transparent text-gray-500  hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"> Logout </a>
					</div>
				</div>
			</div>

			<div class="sm:hidden" id="mobile-menu">
				<div class="pt-2 pb-3 space-y-1">
					<a href="#" class="bg-blue-50 border-blue-500 text-blue-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium" aria-current="page"> Transfer </a>
					<a href="/settings.php" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium"> Settings </a>
					<a href="/logout.php" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium"> Logout </a>
				</div>
			</div>
		</nav>
		<?php
		if (!empty($message)) {
		?>
			<div class="rounded-md bg-green-50 p-4">
				<div class="flex">
					<div class="flex-shrink-0">
						<!-- Heroicon name: solid/check-circle -->
						<svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
							<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
						</svg>
					</div>
					<div class="ml-3">
						<h3 class="text-sm font-medium text-green-800"><?php echo $message; ?></h3>
					</div>
				</div>
			</div>
		<?php } ?>

		<div class="py-10 flex-1">
			<header class="mb-6 text-center">
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<h1 class="text-3xl font-bold leading-tight text-gray-700">Hello <?php echo $user; ?></h1>
					<h2 class="text-xl font-bold leading-tight text-gray-500">Your balance is $<?php echo $balance; ?>!</h2>
				</div>
			</header>
			<main class="container mx-auto px-4 sm:px-6 lg:px-8 sm:max-w-md">
				<section aria-labelledby="users-title">
					<div class="bg-white shadow sm:rounded-t-lg">
						<div class="bg-gray-50 pt-6 pb-4 px-4 sm:px-6 border border-gray-200 sm:rounded-t-lg">
							<div class="flex space-x-3">
								<div class="min-w-0 flex-1">
									<form action="/transfer.php" method="post" class="gap-y-6 grid sm:grid-cols-2 sm:gap-x-6">
										<div class="">
											<label for="to" class="block text-sm font-medium text-gray-700">Transfer to</label>
											<select id="to" name="to" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" required>
												<option disabled>Select an user</option>
												<?php
												if (!empty($users)) {
													foreach ($users as $user) {
												?>
														<option value="<?php echo $user['username']; ?>">
															<?php echo $user['name']; ?> - $<?php echo $user['balance']; ?>
														</option>
													<?php
													}
												} else {
													?>
												<?php } ?>
											</select>
										</div>
										<div class="">
											<label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
											<input type="number" min="0" name="amount" id="amount" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
										</div>
										<div class="py-3 sm:col-span-2">
											<button type="submit" class="inline-flex w-full justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Transfer</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</section>
			</main>
		</div>
		<footer class="bg-white border-t border-gray-200">
			<div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 flex items-center justify-center sm:justify-between sm:flex-row-reverse">
				<a href="/support.php" class="text-gray-600 hover:text-gray-900">
					Need Help?
				</a>
			</div>
		</footer>
	</div>
</body>

</html>