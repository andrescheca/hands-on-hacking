<?php
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

$message = isset($_GET['correct']) ? "Message sent successfully" : "";
$title = isset($_POST['title']) ? $_POST['title'] : "";
$post_message = isset($_POST['message']) ? $_POST['message'] : "";

// Check if a post request has been done
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {
		if (!empty($title) && !empty($post_message)) {
			// Insert a new message
			$stmt = $mysqli->prepare("INSERT INTO messages (title, message) VALUES (?, ?)");
			$stmt->bind_param("ss", $title, $post_message);
			$stmt->execute();
			header("Location: /support.php?correct=true");
		} else {
			$message = "Title and message are required";
		}
	} catch (Exception $e) {
		$message = "Error: " . $e->getMessage();
	}
}

?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">

<head>
	<link href="/css/main.css" rel="stylesheet">
</head>

<body class="h-full">
	<div class="min-h-full">
		<nav class="bg-white border-b border-gray-200">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="justify-between h-16 hidden sm:flex">
					<div class="flex">
						<div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
							<a href="/" class="inline-flex items-center px-1 pt-1  text-sm  text-gray-500  hover:text-gray-700 font-medium"> Transfer </a>
							<a href="/settings.php" class="inline-flex items-center px-1 pt-1  text-sm  text-gray-500  hover:text-gray-700 font-medium"> Settings </a>
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
					<a href="/settings.php" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium"> Settings </a>
					<a href="/logout.php" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium"> Logout </a>
				</div>
			</div>
		</nav>

		<div class="py-10">
			<header class="mb-6 text-center">
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<h1 class="text-3xl font-bold leading-tight text-gray-700 capitalize">Send a message to support</h1>
					<h2 class="text-gray-500 mt-3">Send us a message and we will get back to you.</h2>
				</div>
			</header>
			<main class="container mx-auto px-4 sm:px-6 lg:px-8">
				<form action="/support.php" method="post">
					<div class="shadow sm:rounded-md sm:overflow-hidden">
						<div class="bg-white py-6 px-4 space-y-6 sm:p-6">
							<div>
								<p class="mt-1 text-sm text-gray-500">Please send us a message.</p>
							</div>

							<div class="grid grid-cols-6 gap-6">
								<div class="col-span-6">
									<label for="title" class="block text-sm font-medium text-gray-700">Title</label>
									<input required type="text" name="title" id="title" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
								</div>

								<div class="col-span-6">
									<label for="message" class="block text-sm font-medium text-gray-700">Your message</label>
									<div class="mt-1">
										<textarea required rows="4" name="message" id="message" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
									</div>
								</div>
							</div>
							<?php
							if ($message !== "") {
							?>
								<div class="rounded-md bg-green-50 p-4">
									<div class="flex">
										<div class="flex-shrink-0">
											<svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
												<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
											</svg>
										</div>
										<div class="ml-3 block">
											<h3 class="text-sm font-medium text-green-800">Thanks!</h3>
											<div class=" text-sm text-green-700">
												<p><?php echo $message; ?></p>
											</div>
										</div>
									</div>
								</div>
							<?php
							}
							?>
						</div>
						<div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
							<button type="submit" class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Send</button>
						</div>
					</div>
				</form>

			</main>
		</div>
	</div>
</body>

</html>