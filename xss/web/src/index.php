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

$message = "";
$title = isset($_POST['title']) ? $_POST['title'] : "";
$content = isset($_POST['content']) ? $_POST['content'] : "";
$posts = [];

// Check if a post request has been done
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {
		if (!empty($title) && !empty($content)) {
			// Insert a new post
			$stmt = $mysqli->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
			$stmt->bind_param("ss", $title, $content);
			$stmt->execute();
			$message = "Post added successfully";
		} else {
			$message = "Title and content are required";
		}
		header("Location: /");
	} catch (Exception $e) {
		$message = "Error: " . $e->getMessage();
	}
}
try {
	$query = "SELECT * FROM posts ORDER BY created_at DESC";

	$stmt = $mysqli->prepare($query);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$posts[] = $row;
		}
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
				<div class="justify-between h-16 hidden sm:flex sm:flex-row-reverse">
					<div class="hidden sm:ml-6 sm:flex sm:items-center">
						<a href="/support.php" class="border-transparent text-gray-500  hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"> Problems? Send a message to support </a>
					</div>
				</div>
			</div>

			<div class="sm:hidden" id="mobile-menu">
				<div class="pt-2 pb-3 space-y-1">
					<a href="/support.php" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium"> Problems? Send a message to support </a>
				</div>
			</div>
		</nav>

		<div class="py-10">
			<header class="mb-6 text-center">
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<h1 class="text-3xl font-bold leading-tight text-gray-700">Write some posts!</h1>
				</div>
			</header>
			<main class="container mx-auto px-4 sm:px-6 lg:px-8">
				<section aria-labelledby="posts-title">
					<div class="bg-white shadow sm:rounded-t-lg">
						<div class="bg-gray-50 pt-6 pb-4 px-4 sm:px-6 border border-gray-200 sm:rounded-t-lg">
							<div class="flex space-x-3">
								<div class="min-w-0 flex-1">
									<form action="/" method="post">
										<div class="border border-gray-300 rounded-lg shadow-sm overflow-hidden focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500">
											<label for="title" class="sr-only">Title</label>
											<input type="text" name="title" id="title" class="block w-full border-0 pt-2.5 text-lg font-medium placeholder-gray-500 focus:ring-0" placeholder="Title">
											<label for="content" class="sr-only">Description</label>
											<textarea rows="2" name="content" id="content" class="block w-full border-0 py-0 resize-none placeholder-gray-500 focus:ring-0 sm:text-sm" placeholder="Write your post content..."></textarea>
										</div>
										<div class="mt-3 flex items-center justify-between">
											<div class="inline-flex items-start text-sm space-x-2 text-gray-500 ">
												<svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
													<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
												</svg>
												<span> Some HTML is okay. </span>
											</div>
											<button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Create</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="divide-y divide-gray-200">
							<div class="px-4 py-6 sm:px-6">
								<ul role="list" class="divide-y">
									<?php
									// If there are posts, display them
									if (!empty($posts)) {
										foreach ($posts as $post) {
									?>
											<li class="py-6">
												<div>
													<div class="text-sm">
														<a href="/view.php?id=<?php echo $post['id']; ?>" class="font-medium text-gray-900 capitalize underline text-lg"><?php echo htmlentities($post['title']); ?></a>
													</div>
													<div class="mt-1 text-sm text-gray-700">
														<p class="w-full text-ellipsis overflow-auto block">
															<?php
															// Get an excerpt of the content
															$excerpt = substr($post['content'], 0, 100);
															echo htmlentities($excerpt);
															?></p>
													</div>
													<div class="mt-2 text-sm space-x-2">
														<span class="text-gray-500 font-medium">
															<?php
															// Show created_at date and time
															echo date('h:i:s A - F j, Y', strtotime($post['created_at']));
															?>
														</span>
													</div>
												</div>
											</li>
										<?php
										}
									} else {
										?>
										<p class="text-center">No posts yet!</p>
									<?php } ?>

								</ul>
							</div>
						</div>

					</div>
				</section>
			</main>
		</div>
	</div>
</body>

</html>