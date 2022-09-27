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
$message = "";
$success = false;
$name = isset($_POST['name']) ? $_POST['name'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";
$password_repeat = isset($_POST['password-repeat']) ? $_POST['password-repeat'] : "";
$user = '';

// Check if a post request has been done
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {
		// Update the user name, email and/or password depending if they are empty or not.
		if (!empty($name)) {
			$query = "UPDATE users SET name = ? WHERE username = '$_SESSION[user]'";
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param('s', $name);
			$stmt->execute();
			$stmt->close();
		}
		if (!empty($email)) {
			$query = "UPDATE users SET email = ? WHERE username = '$_SESSION[user]'";
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->close();
		}
		if (!empty($password)) {
			if ($password === $password_repeat) {
				$query = "UPDATE users SET password = ? WHERE username = '$_SESSION[user]'";
				$stmt = $mysqli->prepare($query);
				$md5_password = md5($password);
				$stmt->bind_param('s', $md5_password);
				$stmt->execute();
				$stmt->close();
			} else {
				$message = "The passwords do not match.";
			}
		}
		if ($message === "") {
			$message = "Your changes have been saved.";
			$success = true;
		}
	} catch (Exception $e) {
		$message = "Error: " . $e->getMessage();
	}
}
try {
	$query = "SELECT * FROM users WHERE username = '$_SESSION[user]' LIMIT 1";

	$stmt = $mysqli->prepare($query);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	if ($result->num_rows > 0) {
		$user = $result->fetch_assoc();
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
							<a href="/" class="text-gray-500 inline-flex items-center px-1 pt-1 text-sm font-medium"> Transfer </a>
							<a href="#" class="border-blue-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium" aria-current="page"> Settings </a>
						</div>
					</div>
					<div class="hidden sm:ml-6 sm:flex sm:items-center">
						<a href="/logout.php" class="border-transparent text-gray-500  hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"> Logout </a>
					</div>
				</div>
			</div>

			<div class="sm:hidden" id="mobile-menu">
				<div class="pt-2 pb-3 space-y-1">
					<a href="/" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium"> Transfer </a>
					<a href="#" class="bg-blue-50 border-blue-500 text-blue-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium" aria-current="page"> Settings </a>
					<a href="/logout.php" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium"> Logout </a>
				</div>
			</div>
		</nav>
		<?php
		if (!empty($message)) {
		?>
			<div class="rounded-md <?php echo $success ? "bg-green-50" : "bg-red-50"; ?> p-4">
				<div class="flex">
					<div class="flex-shrink-0">
						<?php if ($success) { ?>
							<!-- Heroicon name: solid/check-circle -->
							<svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
								<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
							</svg>
						<?php } else { ?>
							<!-- Heroicon name: solid/x-circle -->
							<svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
								<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
							</svg>
						<?php } ?>
					</div>
					<div class="ml-3">
						<h3 class="text-sm font-medium <?php echo $success ? "text-green-800" : "text-red-800"; ?>"><?php echo $message; ?></h3>
					</div>
				</div>
			</div>
		<?php } ?>

		<div class="py-10 flex-1">
			<header class="mb-6 text-center">
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<h1 class="text-3xl font-bold leading-tight text-gray-700"><?php echo htmlentities($user['name']); ?></h1>
				</div>
			</header>
			<main class="container mx-auto px-4 sm:px-6 lg:px-8 sm:max-w-3xl">
				<div>
					<div class="md:grid md:grid-cols-3 md:gap-6">
						<div class="md:col-span-1">
							<div class="px-4 sm:px-0">
								<h3 class="text-lg font-medium leading-6 text-gray-900">Profile</h3>
								<p class="mt-1 text-sm text-gray-600">Here you can easily update your profile.</p>
							</div>
						</div>
						<div class="mt-5 md:mt-0 md:col-span-2">
							<form action="#" method="POST">
								<div class="shadow overflow-hidden md:rounded-md">
									<div class="px-4 py-5 bg-white md:p-6">
										<div class="grid grid-cols-6 gap-6">
											<div class="col-span-6 md:col-span-3">
												<label for="name" class="block text-sm font-medium text-gray-700">First name</label>
												<input type="text" value="<?php echo htmlentities($user['name']); ?>" name="name" id="name" autocomplete="given-name" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm md:text-sm border-gray-300 rounded-md">
											</div>
											<div class="col-span-6 md:col-span-3">
												<label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
												<input type="text" value="<?php echo htmlentities($user['email']); ?>" name="email" id="email" autocomplete="email" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm md:text-sm border-gray-300 rounded-md">
											</div>

											<div class="col-span-6">
												<label for="password" class="block text-sm font-medium text-gray-700">Password</label>
												<input type="password" name="password" id="password" autocomplete="password" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm md:text-sm border-gray-300 rounded-md">
											</div>

											<div class="col-span-6">
												<label for="password-repeat" class="block text-sm font-medium text-gray-700">Repeat Password</label>
												<input type="password" name="password-repeat" id="password-repeat" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm md:text-sm border-gray-300 rounded-md">
											</div>
										</div>
									</div>
									<div class="px-4 py-3 bg-gray-50 text-right md:px-6">
										<button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Save</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
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