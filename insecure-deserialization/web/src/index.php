<?php
// Import user file
require_once 'user.php';

$session = null;
$is_admin = false;
$user = new User('empty');

// Check if a cookie with the session exists
if (isset($_COOKIE['INSECURE_SESSION'])) {
	$session = $_COOKIE['INSECURE_SESSION'];
	$user = unserialize($session);
	// Get the user from the session and create a new user object
}
// If is empty then redirect to the login page
if (empty($session)) {
	header("Location: /login.php");
}

// Check if the user name and password match for "user"
if ($user->role === 'admin') {
	$is_admin = true;
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
							<a href="#" class="border-blue-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium" aria-current="page"> Home </a>
						</div>
					</div>
					<div class="hidden sm:ml-6 sm:flex sm:items-center">
						<a href="/logout.php" class="border-transparent text-gray-500  hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"> Logout </a>
					</div>
				</div>
			</div>

			<div class="sm:hidden" id="mobile-menu">
				<div class="pt-2 pb-3 space-y-1">
					<a href="#" class="bg-blue-50 border-blue-500 text-blue-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium" aria-current="page"> Home </a>
					<a href="/logout.php" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium"> Logout </a>
				</div>
			</div>
		</nav>

		<div class="py-10">
			<header>
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<h1 class="text-center text-3xl font-bold leading-tight text-gray-900">Welcome <?php echo ($user->username); ?>!</h1>
				</div>
			</header>
			<main>
				<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
					<?php if ($is_admin) { ?>
						<div class="">
							<div class="my-8 text-center text-gray-700">
								Click on the links below to download the database configuration files.
							</div>
						</div>
					<? } else { ?>
						<div class="px-4 py-8 sm:px-0 max-w-xl mx-auto">
							<p class="text-center text-gray-700">You are not an admin</p>
						</div>
					<?php } ?>
					<div class="px-4 sm:px-0 max-w-xl mx-auto">
						<p class="text-center text-gray-700">These are the current available databases:</p>
						<ul class="list-item mt-3 text-gray-700">
							<li class="list-disc"><?php if ($is_admin) { ?><a class="underline text-blue-500" href="download.php?file=mysql.conf">MySQL 8.0 </a><?php } else { ?> MySQL 8.0 <?php } ?></li>
							<li class="list-disc"><?php if ($is_admin) { ?><a class="underline text-blue-500" href="download.php?file=postgresql.conf">PostgreSQL 12.3 </a><?php } else { ?> PostgreSQL 12.3 <?php } ?></li>
							<li class="list-disc"><?php if ($is_admin) { ?><a class="underline text-blue-500" href="download.php?file=mongo.conf">MongoDB 4.2 </a><?php } else { ?> MongoDB 4.2 <?php } ?></li>
							<li class="list-disc"><?php if ($is_admin) { ?><a class="underline text-blue-500" href="download.php?file=redis.conf">Redis 5.0 </a><?php } else { ?> Redis 5.0 <?php } ?></li>
							<li class="list-disc"><?php if ($is_admin) { ?><a class="underline text-blue-500" href="download.php?file=elasticsearch.conf">Elasticsearch 7.6 </a><?php } else { ?> Elasticsearch 7.6 <?php } ?></li>
							<li class="list-disc"><?php if ($is_admin) { ?><a class="underline text-blue-500" href="download.php?file=cassandra.conf">Cassandra 3.11 </a><?php } else { ?> Cassandra 3.11 <?php } ?></li>
						</ul>
					</div>
				</div>
			</main>
		</div>
	</div>
</body>

</html>