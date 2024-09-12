<?php
session_start();
include "dbConnect.php";

// Prepare variables for logging
$session_id = session_id();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$action = 'logout';

// Log logout event
$stmt = $conn->prepare("INSERT INTO session_logs (session_id, username, action) VALUES (?, ?, ?)");
if ($stmt) {
    $stmt->bind_param("sss", $session_id, $username, $action);
    $stmt->execute();
    $stmt->close();
}

// Clear session
session_unset();
session_destroy();

// Redirect to login page
header("Location: login.php");
exit();
?>