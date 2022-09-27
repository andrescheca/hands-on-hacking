<?php
if (!isset($_COOKIE['session_id']) || $_COOKIE['session_id'] !== 'This cookie should be a secret') {
	header('Location: /');
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

$message = [];
try {
	// Get message to admin
	$stmt = $mysqli->prepare("SELECT m.id, m.url FROM messages m WHERE m.read = 0 ORDER BY m.id DESC LIMIT 1");
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();

	if ($result->num_rows > 0) {
		$message = $result->fetch_assoc();
		// Set read to 1 for each read message
		$stmt = $mysqli->prepare("UPDATE messages m SET m.read = 1 WHERE m.id = ?");
		$stmt->bind_param('i', $message['id']);
		$stmt->execute();
		$stmt->close();
	}
	if ($message) {
		header("Location: " . $message['url']);
	}
} catch (Exception $e) {
	echo "Error: " . $e->getMessage() . "<br/>" . "Please try again in a few minutes, the database is being created right now.";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
	Empty
</body>

</html>