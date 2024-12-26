<?php
session_start();
if (isset($_SESSION['username'])) {
    include 'dbConnect.php';

    // Check if 'cid' is passed in the URL
    if (isset($_GET['cid']) && !empty($_GET['cid'])) {
        $cid = intval($_GET['cid']);

        // Fetch the craft details
        $sql = "SELECT c.title, c.description, c.price, c.quantity, c.pdate, c.category, u.firstName, u.email, u.phone
                FROM craft c
                JOIN users u ON c.uid = u.uid
                WHERE c.cid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $craft = $result->fetch_assoc();

            // Fetch craft images
            $imageSql = "SELECT image_description FROM images WHERE cid = ?";
            $imgStmt = $conn->prepare($imageSql);
            $imgStmt->bind_param("i", $cid);
            $imgStmt->execute();
            $imgResult = $imgStmt->get_result();

            $images = [];
            while ($imgRow = $imgResult->fetch_assoc()) {
                $images[] = $imgRow['image_description'];
            }

            $craft['images'] = $images;
        } else {
            echo "Craft not found!";
            exit();
        }
    } else {
        echo "Invalid request!";
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars($craft['title']); ?></title>
    <link href="../css/craftDetails.css" rel="stylesheet">
</head>
<body>
    <section class="craft-details">
        <h1 style="text-transform: uppercase; font-size: 30px; margin-left: 5%;"><?php echo htmlspecialchars($craft['title']); ?></h1>
        <div class="details-container">
            <div class="images-section">
                <?php if (!empty($craft['images'])): ?>
                    <?php foreach ($craft['images'] as $image): ?>
                        <img src="uploads/<?php echo htmlspecialchars($image); ?>" alt="Craft Image">
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No images available</p>
                <?php endif; ?>
            </div>
            <div class="info-section">
                <p><strong>Category:</strong> <?php echo htmlspecialchars($craft['category']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($craft['description']); ?></p>
                <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($craft['price']); ?></p>
                <p><strong>Quantity:</strong> <?php echo htmlspecialchars($craft['quantity']); ?></p>
                <p><strong>Uploaded on:</strong> <?php echo htmlspecialchars($craft['pdate']); ?></p>
                <h3>Seller Details</h3>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($craft['firstName']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($craft['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($craft['phone']); ?></p>
            </div>
        </div>
    </section>
</body>
</html>