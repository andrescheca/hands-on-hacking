<?php
// Import user file
require_once 'user.php';

$session = '';
$message = '';

// Check if a cookie with the session exists
if (isset($_COOKIE['INSECURE_SESSION'])) {
	// If it exists check if it is valid
	$session = $_COOKIE['INSECURE_SESSION'];
	$session = unserialize($session);
	// Get the user from the session and create a new user object
	$user = new User($session['role'], $session['username']);
}

// If it is not empty then redirect to the home page
if (!empty($session)) {
	header("Location: /");
}

// Check if a post request has been done
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Check if the user name and password match for "user"
	if ($_POST['username'] === "user" && $_POST['password'] === "user") {
		// Create a user object
		$user = new User($_POST['username'], 'user');
		// Serialize the user
		$user = serialize($user);
		// Set the cookie
		setcookie('INSECURE_SESSION', $user, time() + 3600, '/');
		// Redirect to the home page
		header("Location: /");
	} else {
		// If the user name and password do not match then show an error message
		$message = "Invalid username or password";
	}
}

?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">

<head>
	<link href="/css/main.css" rel="stylesheet">
</head>

<body class="h-full">
	<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
		<div class="max-w-md w-full space-y-8">
			<div>
				<h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Database Management</h2>
				<p class="mt-2 text-center text-sm text-gray-600">
					Please sign in to continue.
				</p>
			</div>
			<form class="mt-8 space-y-6" action="/login.php" method="post">
				<input type="hidden" name="remember" value="true">
				<div class="rounded-md shadow-sm -space-y-px">
					<div>
						<label for="username" class="sr-only">Username</label>
						<input id="username" name="username" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Username">
					</div>
					<div>
						<label for="password" class="sr-only">Password</label>
						<input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Password">
					</div>
				</div>

				<div class="flex items-center justify-between">
					<div class="flex items-center">
						<input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
						<label for="remember-me" class="ml-2 block text-sm text-gray-900"> Remember me </label>
					</div>
				</div>

				<div>
					<button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
						<span class="absolute left-0 inset-y-0 flex items-center pl-3">
							<!-- Heroicon name: solid/lock-closed -->
							<svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
								<path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
							</svg>
						</span>
						Sign in
					</button>
				</div>
				<?php if ($message !== "") { ?>
					<div class="rounded-md bg-red-50 p-4">
						<div class="flex">
							<div class="flex-shrink-0">
								<!-- Heroicon name: solid/x-circle -->
								<svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
								</svg>
							</div>
							<div class="ml-3">
								<h3 class="text-sm font-medium text-red-800"><?php echo $message; ?></h3>
							</div>
						</div>
					</div>
				<?php } ?>
			</form>
		</div>
	</div>

</body>

</html>