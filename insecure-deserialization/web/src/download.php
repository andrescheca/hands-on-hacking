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
// Get the config name from the file query param
$config_name = $_GET['file'];
// Download the file
if ($is_admin) {
	// Check if the file exists in the configs directory
	if (file_exists("configs/$config_name")) {
		// Download the file
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . basename("configs/$config_name"));
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize("configs/$config_name"));
		readfile("configs/$config_name");
		exit;
	} else {
		echo "File not found";
	}
} else {
	echo "You are not authorized to download this file";
}
