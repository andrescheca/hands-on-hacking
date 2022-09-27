<?php
$post_id = isset($_GET['id']) ? $_GET['id'] : null;
$post = null;
$message = '';

if ($post_id) {
	try {
		$mysqli = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']);
		// Check connection
		if ($mysqli->connect_errno) {
			echo "Failed to connect to MySQL: " . $mysqli->connect_error;
			exit();
		}
		// Save post info to $post;
		$stmt = $mysqli->prepare("SELECT p.id, p.title, p.content, p.created_at FROM posts p WHERE p.id = ?");
		$stmt->bind_param('i', $post_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		if ($result->num_rows > 0) {
			$post = $result->fetch_assoc();
		} else {
			$message = "Couldn't find post with id: " . $post_id;
		}
	} catch (Exception $e) {
		echo "Error: " . $e->getMessage() . "<br/>" . "Please try again in a few minutes, the database is being created right now.";
		exit();
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
							<a href="/" class="text-gray-700 inline-flex items-center px-1 pt-1 text-sm font-medium capitalize"> Create a post </a>
						</div>
					</div>
					<div class="hidden sm:ml-6 sm:flex sm:items-center">
						<a href="/support.php" class="border-transparent text-gray-500  hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"> Problems? Send a message to support </a>
					</div>
				</div>
			</div>

			<div class="sm:hidden" id="mobile-menu">
				<div class="pt-2 pb-3 space-y-1">
					<a href="/" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium capitalize"> Create a post </a>
					<a href="/support.php" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium"> Problems? Send a message to support </a>
				</div>
			</div>
		</nav>


		<?php
		// Show post content
		if ($post) {
		?>
			<div class="py-10">
				<header class="mb-6 text-center">
					<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
						<h1 class="text-3xl font-bold leading-tight text-gray-700 uppercase"><?php echo htmlentities($post['title']); ?>
						</h1>
					</div>
				</header>
				<main class="container mx-auto px-4 sm:px-6 lg:px-8">
					<section aria-labelledby="posts-title">
						<div class="bg-white shadow">
							<div class="px-4 py-6 sm:px-6">
								<div>
									<div class="mt-1 text-sm text-gray-700">
										<p class="w-full text-ellipsis overflow-auto block">
											<?php
											echo $post['content'];
											?></p>
									</div>
									<div class="mt-2 text-sm space-x-2 border-t border-gray-200 pt-3">
										<span class="text-gray-500 font-medium">
											<?php
											// Show created_at date and time
											echo date('h:i:s A - F j, Y', strtotime($post['created_at']));
											?>
										</span>
									</div>
								</div>
							</div>

						</div>
					</section>
				</main>
			</div>
		<?php
		} else {
		?>
			<p class="text-center mt-3"><?php echo $message; ?></p>
		<?php } ?>
	</div>
</body>

</html>