<?php
if (!isset($_COOKIE['is_admin']) || $_COOKIE['is_admin'] !== 'tN5pEAc1ebqvvlwWkEnY') {
	header('Location: /');
}
session_start();
// Set the session cookie to httponly
setcookie(session_name(), session_id(), 0, "", "", false, true);
$_SESSION['user'] = 'admin';

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
	$stmt = $mysqli->prepare("SELECT m.id, m.message FROM messages m WHERE m.read = 0 ORDER BY m.id DESC LIMIT 1");
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();

	if ($result->num_rows > 0) {
		$message = $result->fetch_assoc();
		// Set read to 1 for each message read
		$stmt = $mysqli->prepare("UPDATE messages m SET m.read = 1 WHERE m.id = ?");
		$stmt->bind_param('i', $message['id']);
		$stmt->execute();
		$stmt->close();
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
	<?php
	if (count($message) > 0) {
		$user_message = $message['message'];
	} else {
		$user_message = 'Empty';
	}
	echo $user_message;
	?>
</body>

</html>