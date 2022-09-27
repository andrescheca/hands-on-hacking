<?php

// Check if a cookie with the session exists
if (isset($_COOKIE['INSECURE_SESSION'])) {
	// If it exists then destroy it
	setcookie('INSECURE_SESSION', '', time() - 3600, '/');
}

header("Location: /login.php");
