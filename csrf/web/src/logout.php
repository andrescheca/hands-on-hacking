<?php
// Logout a user and redirect to the index.php page
// Path: sqli/src/logout.php
session_start();
session_destroy();
header("Location: /login.php");
