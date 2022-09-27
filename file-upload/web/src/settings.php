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
$profile_picture =  isset($_FILES['profile-picture']) ? $_FILES['profile-picture'] : "";
$user = '';

// Check if a post request has been done
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {
		if (!empty($profile_picture)) {
			$target_dir = "uploads/";
			$image_extension = strtolower(pathinfo($profile_picture["name"], PATHINFO_EXTENSION));
			$random_name = uniqid() . "." . $image_extension;
			$target_file = $target_dir . basename($random_name);

			$upload_ok = 1;
			if (file_exists($target_file)) {
				$upload_ok = 0;
			}
			// Check file size
			if ($profile_picture["size"] > 500000) {
				$upload_ok = 0;
			}
			// Check if $upload_ok is set to 0 by an error
			if ($upload_ok == 0) {
				$message = "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
			} else if (move_uploaded_file($profile_picture["tmp_name"], $target_file)) {
				$query = "UPDATE users SET profile_url = ? WHERE username = '$_SESSION[user]'";
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param('s', $target_file);
				$stmt->execute();
				$stmt->close();
			} else {
				$message = "Sorry, your file was not uploaded.";
			}
		}
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
							<a href="/" class="text-gray-500 inline-flex items-center px-1 pt-1 text-sm font-medium"> My Profile </a>
						</div>
					</div>
					<div class="hidden sm:ml-6 sm:flex sm:items-center">
						<a href="/logout.php" class="border-transparent text-gray-500  hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"> Logout </a>
					</div>
				</div>
			</div>

			<div class="sm:hidden" id="mobile-menu">
				<div class="pt-2 pb-3 space-y-1">
					<a href="/" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium"> My Profile </a>
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
					<h1 class="text-3xl font-bold leading-tight text-gray-700">This is a preview of your profile</h1>
				</div>
			</header>

			<section class="border-t border-gray-300">
				<main class="py-10">
					<!-- Page header -->
					<div class="max-w-3xl mx-auto px-4 sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-7xl lg:px-8">
						<div class="flex items-center space-x-5">
							<div class="flex-shrink-0">
								<div class="relative">
									<img class="h-16 w-16 rounded-full" src="<?php echo $user['profile_url']; ?>" alt="profile picture" aria-label="profile picture" />
									<span class="absolute inset-0 shadow-inner rounded-full" aria-hidden="true"></span>
								</div>
							</div>
							<div>
								<h1 class="text-2xl font-bold text-gray-900"><?php echo htmlentities($user['name']); ?></h1>
								<p class="text-sm font-medium text-gray-500">A really awesome description for the user</p>
							</div>
						</div>
					</div>

					<div class="mt-8 max-w-3xl mx-auto ">
						<div class="space-y-6 lg:col-start-1 lg:col-span-2">
							<!-- Description list-->
							<section aria-labelledby="user-information-title">
								<div class="bg-white shadow sm:rounded-lg">
									<div class="px-4 py-5 sm:px-6">
										<h2 id="user-information-title" class="text-lg leading-6 font-medium text-gray-900">User Information</h2>
										<p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details.</p>
									</div>
									<div class="border-t border-gray-200 px-4 py-5 sm:px-6">
										<dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
											<div class="sm:col-span-1">
												<dt class="text-sm font-medium text-gray-500">Email address</dt>
												<dd class="mt-1 text-sm text-gray-900"><?php echo htmlentities($user['email']); ?></dd>
											</div>
											<div class="sm:col-span-1">
												<dt class="text-sm font-medium text-gray-500">Username</dt>
												<dd class="mt-1 text-sm text-gray-900"><?php echo htmlentities($user['username']); ?></dd>
											</div>
											<div class="sm:col-span-2">
												<dt class="text-sm font-medium text-gray-500">About</dt>
												<dd class="mt-1 text-sm text-gray-900">This is a more extended description and more awesome description of the current logged in user, clearly this profile management application is impossible to hack.</dd>
											</div>
										</dl>
									</div>
								</div>
							</section>
						</div>
					</div>
				</main>
			</section>
		</div>
	</div>
</body>

</html>