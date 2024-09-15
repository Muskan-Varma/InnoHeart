<?php
session_start();
include 'dbConnect.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's username from the session
$username = $_SESSION['username'];

// Fetch user data from the database
$sql = "SELECT uid, firstName, lastName, phone, email, dob, gender, rdate FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "No user data found.";
    exit();
}
$stmt->close();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['updateProfile'])) {
        // Update profile information
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
    
        $sql = "UPDATE users SET firstName = ?, lastName = ?, phone = ?, email = ? WHERE uid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $firstName, $lastName, $phone, $email, $user['uid']); // Corrected parameter types
        $stmt->execute();
        $stmt->close();
    
        echo "Profile updated successfully.";    

    } elseif (isset($_POST['updateCraft'])) {
        // Update craft
        $craft_id = $_POST['craft_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        $sql = "UPDATE craft SET title = ?, description = ?, price = ?, quantity = ? WHERE cid = ? AND uid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdiii", $title, $description, $price, $quantity, $craft_id, $user['uid']);
        $stmt->execute();
        $stmt->close();

        echo "Craft updated successfully.";

    } elseif (isset($_POST['deleteCraft'])) {
        // Delete craft
        $craft_id = $_POST['craft_id'];

        $sql = "DELETE FROM craft WHERE cid = ? AND uid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $craft_id, $user['uid']);
        $stmt->execute();
        $stmt->close();

        echo "Craft deleted successfully.";

    } elseif (isset($_POST['changePassword'])) {
        // Change password
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        // Verify current password
        $sql = "SELECT pass FROM users WHERE uid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user['uid']);
        $stmt->execute();
        $stmt->bind_result($hashedPassword); // Bind the result
        $stmt->fetch(); // Fetch the result
        $stmt->close(); // Close the statement after fetching the result

        if (password_verify($currentPassword, $hashedPassword)) {
            // Check if new passwords match
            if ($newPassword === $confirmPassword) {
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET pass = ? WHERE uid = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $newPasswordHash, $user['uid']);
                $stmt->execute();
                $stmt->close(); // Close after executing

                echo "Password changed successfully.";
            } else {
                echo "New passwords do not match.";
            }
        } else {
            echo "Current password is incorrect.";
        }

    } elseif (isset($_POST['deleteAccount'])) {
        // Delete account
        $sql = "DELETE FROM users WHERE uid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user['uid']);
        $stmt->execute();
        $stmt->close();

        // Also delete user-related data if needed (e.g., crafts)
        $sql = "DELETE FROM craft WHERE uid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user['uid']);
        $stmt->execute();
        $stmt->close();

        // Destroy session and redirect to homepage
        session_destroy();
        header("Location: index.php");
        exit();
    }
}

// Fetch crafts uploaded by the logged-in user
$uid = $user['uid'];
$sql = "SELECT cid, title, description, price, quantity, pdate FROM craft WHERE uid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid);
$stmt->execute();
$craftsResult = $stmt->get_result();

$crafts = [];
while ($row = $craftsResult->fetch_assoc()) {
    $crafts[] = $row;
}
$stmt->close();

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/settings.css" rel="stylesheet">
</head>
<body>
    <h2>Account Settings</h2>

    <!-- Update Profile Section -->
    <section>
        <h3>Update Profile Information</h3>
        <form method="post" action="settings.php">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($user['firstName']); ?>"><br>
            
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($user['lastName']); ?>"><br>
            
            <label for="phone">Phone No.:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"><br>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br>
            
            <button type="submit" name="updateProfile">Update Profile</button>
        </form>
    </section>

    <!-- Manage Crafts Section -->
    <section>
        <h3>Manage Crafts</h3>
        <?php foreach ($crafts as $craft): ?>
            <div class="craft-item">
                <h4><?php echo htmlspecialchars($craft['title']); ?></h4>
                <p><?php echo htmlspecialchars($craft['description']); ?></p>
                <p>Price: <?php echo htmlspecialchars($craft['price']); ?></p>
                <p>Quantity: <?php echo htmlspecialchars($craft['quantity']); ?></p>
                
                <form method="post" action="settings.php">
                    <input type="hidden" name="craft_id" value="<?php echo htmlspecialchars($craft['cid']); ?>">
                    <button type="button" onclick="showUpdateForm(<?php echo htmlspecialchars(json_encode($craft)); ?>)">Update Craft</button>
                </form>

                <form method="post" action="settings.php">
                    <input type="hidden" name="craft_id" value="<?php echo htmlspecialchars($craft['cid']); ?>">
                    <button type="submit" name="deleteCraft" onclick="return confirm('Are you sure you want to delete this craft?')">Delete Craft</button>
                </form>
            </div>
        <?php endforeach; ?>

        <!-- Hidden form for updating craft -->
        <div id="updateForm" style="display:none;">
            <h2>Update Craft</h2>
            <form method="post" action="settings.php">
                <input type="hidden" name="craft_id" id="craft_id">
                <input type="text" name="title" id="title" placeholder="Title">
                <textarea name="description" id="description" placeholder="Description"></textarea>
                <input type="number" name="price" id="price" placeholder="Price">
                <input type="number" name="quantity" id="quantity" placeholder="Quantity">
                <button type="submit" name="updateCraft">Update Craft</button>
            </form>
        </div>
    </section>

    <!-- Change Password Section -->
    <section>
        <h3>Change Password</h3>
        <form method="post" action="settings.php">
            <label for="currentPassword">Current Password:</label>
            <input type="password" id="currentPassword" name="currentPassword"><br>
            
            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword"><br>
            
            <label for="confirmPassword">Confirm New Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword"><br>
            
            <button type="submit" name="changePassword">Change Password</button>
        </form>
    </section>

    <!-- Delete Account Section -->
    <section>
        <h3>Delete Account</h3>
        <form method="post" action="settings.php">
            <button type="submit" name="deleteAccount" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">Delete Account</button>
        </form>
    </section>

    <script>
        function showUpdateForm(craft) {
            document.getElementById('craft_id').value = craft.cid; // Use 'cid' instead of 'id'
            document.getElementById('title').value = craft.title;
            document.getElementById('description').value = craft.description;
            document.getElementById('price').value = craft.price;
            document.getElementById('quantity').value = craft.quantity;
            document.getElementById('updateForm').style.display = 'block';
        }
    </script>
</body>
</html>