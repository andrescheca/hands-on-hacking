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

$to = isset($_POST['to']) ? $_POST['to'] : "";
$amount = isset($_POST['amount']) ? $_POST['amount'] : "";

// Check if a post request has been done
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {
		if (!empty($to) && !empty($amount)) {
			if ($amount < 0) {
				throw new Exception("Amount must be greater than 0");
			}
			// Get the balance of the current user
			$query = "SELECT * FROM users WHERE username = '$_SESSION[user]' LIMIT 1";
			$stmt = $mysqli->prepare($query);
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->close();
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$balance = $row['balance'];
			}
			if ($balance < $amount) {
				throw new Exception("Insufficient balance");
			}
			// Get the balance of the user to transfer to
			$query = "SELECT * FROM users WHERE username = '$to' LIMIT 1";
			$stmt = $mysqli->prepare($query);
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->close();
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$toBalance = $row['balance'];
			}
			// Update the balance of the current user
			$query = "UPDATE users SET balance = balance - $amount WHERE username = '$_SESSION[user]'";
			$stmt = $mysqli->prepare($query);
			$stmt->execute();
			$stmt->close();
			// Update the balance of the user to transfer to
			$query = "UPDATE users SET balance = balance + $amount WHERE username = '$to'";
			$stmt = $mysqli->prepare($query);
			$stmt->execute();
			$stmt->close();
			$message = "Transfer successful";
			// Redirect to the home page
			header("Location: /?message=$message");
		} else {
			throw new Exception("Please fill in all fields");
		}
	} catch (Exception $e) {
		$message = "Error: " . $e->getMessage();
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
		<div class="py-10">
			<header class="mb-6 text-center">
				<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<h1 class="text-3xl font-bold leading-tight text-gray-700"><?php echo $message; ?></h1>
				</div>
			</header>
		</div>
	</div>
</body>

</html>