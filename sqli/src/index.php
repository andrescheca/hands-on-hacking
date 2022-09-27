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
$users = [];
$search = isset($_POST['search']) ? $_POST['search'] : "";
// Check if a post request has been done
try {
	// Check if the user is in the database
	$stmt = $mysqli->prepare("SELECT * FROM users WHERE name LIKE '$search%'");
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();

	if ($result->num_rows > 0) {
		$users = $result->fetch_all(MYSQLI_ASSOC);
	}
} catch (Exception $e) {
	$message = "Error: " . $e->getMessage();
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
							<a href="#" class="border-blue-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium" aria-current="page"> Dashboard </a>
						</div>
					</div>
					<div class="hidden sm:ml-6 sm:flex sm:items-center">
						<a href="/logout.php" class="border-transparent text-gray-500  hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"> Logout </a>
					</div>
				</div>
			</div>

			<div class="sm:hidden" id="mobile-menu">
				<div class="pt-2 pb-3 space-y-1">
					<a href="#" class="bg-blue-50 border-blue-500 text-blue-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium" aria-current="page"> Dashboard </a>
					<a href="/logout.php" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium"> Logout </a>
				</div>
			</div>
		</nav>

		<div class="py-10">
			<header>
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<h1 class="text-3xl font-bold leading-tight text-gray-900">Welcome <?php echo ($_SESSION['user']); ?>!</h1>
				</div>
			</header>
			<main>
				<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
					<div class="px-4 py-8 sm:px-0">
						<p class="text-gray-700">You can search for a user by typing their name in the search bar below.</p>
					</div>
					<form action="/" method="post" class="mx-auto w-full max-w-lg">
						<label for="email" class="block text-sm font-medium text-gray-700">Search users</label>
						<div class="mt-1 flex rounded-md shadow-sm">
							<div class="relative flex items-stretch flex-grow focus-within:z-10">
								<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
									<!-- Heroicon name: solid/users -->
									<svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
										<path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
									</svg>
								</div>
								<input <?php if ($search !== "") {
													echo "value='" . htmlentities($search) . "'";
												} ?> type="text" name="search" id="search" class="focus:ring-blue-500 focus:border-blue-500 block w-full rounded-none rounded-l-md pl-10 sm:text-sm border-gray-300" placeholder="Search a user" autofocus>
							</div>
							<button type="button" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
								<!-- Heroicon name: solid/search -->
								<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
									<path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
								</svg>
								<span>Search</span>
							</button>
						</div>
					</form>
					<?php if ($message !== "") { ?>
						<div class="rounded-md bg-red-50 p-4 mx-auto w-full max-w-lg">
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

					<div class="mt-4 px-4 sm:px-6 lg:px-8">
						<div class="mt-8 flex flex-col">
							<div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
								<div class="inline-block min-w-full py-2 align-middle">
									<div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5 border-r border-l border-gray-200">
										<table class="min-w-full divide-y divide-gray-300">
											<thead class="bg-gray-50">
												<tr>
													<th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">Name</th>
													<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Username</th>
													<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
													<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
												</tr>
											</thead>
											<tbody class="divide-y divide-gray-200 bg-white">
												<?php
												foreach ($users as $user) {
													echo '<tr>';
													echo '<td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">' . $user['name'] . '</td>';
													echo '<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">' . $user['username'] . '</td>';
													echo '<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">' . $user['email'] . '</td>';
													echo '<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">' . ($user['role'] === 'admin' ? '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
													<path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
												</svg>' : '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
												<path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
											</svg>') . '</td>';
													echo '</tr>';
												} ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>
	</div>
</body>

</html>