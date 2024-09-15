<?php
session_start();
include 'dbConnect.php';

if (isset($_POST['craft_id']) && isset($_SESSION['username'])) {
    $cid = $_POST['craft_id'];
    $username = $_SESSION['username'];

    // Check if craft is already in favourites
    $sqlCheck = "SELECT * FROM favourites WHERE username = ? AND cid = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("si", $username, $cid);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows === 0) {
        // If not in favourites, add it
        $sql = "INSERT INTO favourites (username, cid) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $username, $cid);
        
        if ($stmt->execute()) {
            echo "Added to favourites!";
        } else {
            echo "Error: Could not add to favourites.";
        }
    } else {
        echo "Craft already in favourites!";
    }

    $stmt->close();
    $conn->close();
}
?>
