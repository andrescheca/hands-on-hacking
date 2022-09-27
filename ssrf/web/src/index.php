<?php

$image_post = isset($_POST['image']) ? $_POST['image'] : null;
$images = [
	["url" => "https://images.unsplash.com/photo-1469533802599-76ee5be68f7d?auto=format&fit=crop&w=600&q=80", "label" => "Image 1"],
	["url" => "https://images.unsplash.com/photo-1474152042542-1e794677a34b?auto=format&fit=crop&w=600&q=80", "label" => "Image 2"],
	["url" => "https://images.unsplash.com/photo-1471193945509-9ad0617afabf?auto=format&fit=crop&w=600&q=80", "label" => "Image 3"],
	["url" => "https://images.unsplash.com/photo-1453487021979-5b739b2849f4?auto=format&fit=crop&w=600&q=80", "label" => "Image 4"]
]
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">

<head>
	<link href="/css/main.css" rel="stylesheet">
</head>

<body class="h-full">
	<div class="min-h-full flex flex-col">
		<div class="py-10 flex-1">
			<header class="mb-6 text-center">
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<h1 class="text-3xl font-bold leading-tight text-gray-700">Preview an image</h1>
					<h2 class="text-md mt-3 leading-tight text-gray-700">Select an image from Unsplash and preview it</h2>
				</div>
			</header>
			<main class="container mx-auto px-4 sm:px-6 lg:px-8 sm:max-w-md">
				<section aria-labelledby="images">
					<div class="bg-white shadow sm:rounded-t-lg">
						<div class="bg-gray-50 pt-6 pb-4 px-4 sm:px-6 border border-gray-200 sm:rounded-t-lg">
							<div class="flex space-x-3">
								<div class="min-w-0 flex-1">
									<form action="/" method="post" class="gap-y-6 grid">
										<div class="">
											<label for="image" class="block text-sm font-medium text-gray-700">Select an image</label>
											<select id="image" name="image" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" required>
												<option disabled>Select an image</option>
												<?php
												foreach ($images as $image) {
													echo "<option value='{$image['url']}' " . (($image['url'] === $image_post) ? "selected" : '') . ">{$image['label']}</option>";
												}
												?>
											</select>
										</div>
										<div class="py-3">
											<button type="submit" class="inline-flex w-full justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Preview</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</section>
				<section class="mt-6">

					<?php
					if ($image_post) {
						$image = fopen($image_post, 'rb');
						if ($image) {
							$image_content = stream_get_contents($image);
							$base64_image = base64_encode($image_content);
							fclose($image);
							$finfo = new finfo(FILEINFO_MIME_TYPE);
							$mimeType = $finfo->buffer($image_content);
							if ($mimeType === "image/jpeg") {
					?>
								<img src="data:image/png;base64, <?php echo $base64_image; ?>" alt="Preview" class="w-full">
							<?php
							} else {
							?>
								<div class="mt-3 text-center">Invalid image type</div>
								<div class="mt-3">
									<?php echo $image_content; ?>
								</div>
						<?php
							}
						}
					} else {
						?>
						<div class="mt-3 text-center">No image selected</div>
					<?php
					}
					?>

				</section>
			</main>
		</div>
	</div>
</body>

</html>