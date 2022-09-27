<?php
$templates = array(
	array(
		'name' => 'Dashboard',
		'img' => '/images/dashboard.jpg',
		'price' => '99',
		'link' => 'templates/dashboard.html'
	),
	array(
		'name' => 'Home',
		'img' => '/images/home.jpg',
		'price' => '49',
		'link' => 'templates/home.html'
	),
	array(
		'name' => 'Sign In/Out',
		'img' => '/images/signin.jpg',
		'price' => '29',
		'link' => 'templates/signin.html'
	),
	array(
		'name' => 'Landing',
		'img' => '/images/landing.jpg',
		'price' => '79',
		'link' => 'templates/landing.html'
	)
);
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
							<a href="#" class="border-blue-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium" aria-current="page"> Preview </a>
						</div>
					</div>
				</div>
			</div>

			<div class="sm:hidden" id="mobile-menu">
				<div class="pt-2 pb-3 space-y-1">
					<a href="#" class="bg-blue-50 border-blue-500 text-blue-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium" aria-current="page"> Preview </a>
				</div>
			</div>
		</nav>

		<div class="py-10 flex-1">
			<header class="mb-6 text-center">
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<h1 class="text-3xl font-bold leading-tight text-gray-700 capitalize">Welcome to our template preview page</h1>
			</header>
			<main class="container mx-auto px-8 sm:px-6 lg:px-8 sm:max-w-4xl">
				<section aria-labelledby="users-title">
					<div class="bg-white">
						<div class="mx-auto max-w-2xl py-4 px-4 sm:py-8 sm:px-6 lg:max-w-7xl lg:px-8">
							<div class="flex items-center justify-center space-x-4">
								<h2 class="text-lg font-medium text-gray-900">Click each template to preview it</h2>
							</div>
							<div class="mt-6 grid grid-cols-1 gap-x-8 gap-y-8 sm:grid-cols-2 sm:gap-y-10">
								<?php
								foreach ($templates as $template) {
								?>
									<div class="group relative rounded bg-gray-50 p-4">
										<div class="aspect-w-4 aspect-h-3 overflow-hidden rounded-lg bg-gray-100">
											<img src="<?php echo ($template['img']); ?>" alt="<?php echo ($template['name']); ?>" class="object-cover object-center">
											<div class="flex items-end p-4 opacity-0 group-hover:opacity-100" aria-hidden="true">
												<div class="w-full rounded-md bg-white bg-opacity-75 py-2 px-4 text-center text-sm font-medium text-gray-900 backdrop-blur backdrop-filter">Preview template</div>
											</div>
										</div>
										<div class="mt-4 flex items-center justify-between space-x-8 text-base font-light text-gray-900">
											<h3>
												<a href="preview.php?page=<?php echo ($template['link']); ?>">
													<span aria-hidden="true" class="absolute inset-0"></span>
													<?php echo ($template['name']); ?>
												</a>
											</h3>
											<p>$<?php echo ($template['price']); ?></p>
										</div>
									</div>
								<? } ?>
							</div>
						</div>
					</div>
				</section>
			</main>
		</div>
	</div>
</body>

</html>