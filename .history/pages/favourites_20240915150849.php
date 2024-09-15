<?php
session_start();
if (isset($_SESSION['username'])) {
    include 'dbConnect.php';
    $username = $_SESSION['username'];

    // Fetch crafts that are in the user's favourites table
    $sql = "SELECT c.cid, c.title, c.description, c.price, c.quantity, c.pdate, c.category, u.firstName, u.email, u.phone
            FROM favourites f
            JOIN craft c ON f.cid = c.cid
            JOIN users u ON c.uid = u.uid
            WHERE f.username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $favouriteCrafts = [];
    while ($row = $result->fetch_assoc()) {
        // Fetch images for each craft
        $imageSql = "SELECT image_description FROM images WHERE cid = ?";
        $imgStmt = $conn->prepare($imageSql);
        $imgStmt->bind_param("i", $row['cid']);
        $imgStmt->execute();
        $imgResult = $imgStmt->get_result();

        $images = [];
        while ($imgRow = $imgResult->fetch_assoc()) {
            $images[] = $imgRow['image_description'];
        }
        $row['images'] = $images; // Add images to the current craft row

        $favouriteCrafts[] = $row;
        $imgStmt->close();
    }

    $stmt->close();
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Favourites</title>
    <link href="../css/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <h1>Your Favourites</h1>

    <section id="content-section">
        <?php foreach ($favouriteCrafts as $row): ?>
        <div class="card">
            <div class="product-card">
                <!-- Display category if it exists -->
                <?php if (!empty($row['category'])): ?>
                <div class="badge"><?php echo htmlspecialchars($row['category']); ?></div>
                <?php endif; ?>

                <!-- Display images -->
                <div class="product-tumb">
                    <?php if (!empty($row['images'])): ?>
                    <div class="image-slider">
                        <?php foreach ($row['images'] as $index => $image): ?>
                        <img src="uploads/<?php echo htmlspecialchars($image); ?>" alt="Craft Image" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                        <?php endforeach; ?>
                        <?php if (count($row['images']) > 1): ?>
                            <button class="prev" onclick="changeImage(this, -1)">&#10094;</button>
                            <button class="next" onclick="changeImage(this, 1)">&#10095;</button>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <p>No images available</p>
                    <?php endif; ?>
                </div>

                <div class="product-details">
                    <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <div class="product-bottom-details">
                        <div class="product-price">
                            <?php echo htmlspecialchars($row['price']); ?>
                            <br>
                            <small>In Stock: <?php echo htmlspecialchars($row['quantity']); ?></small>
                        </div>
                        <div class="product-links">
                            <!-- Buy button -->
                            <button class="buy-btn" onclick="showSellerDetails(<?php echo $row['cid']; ?>)">Buy</button>
                        </div>
                    </div>

                    <div class="seller-details" id="seller-<?php echo $row['cid']; ?>" style="display: none;">
                        <strong>Seller Details:</strong>
                        <p>Name: <?php echo htmlspecialchars($row['firstName']); ?></p>
                        <p>Email: <?php echo htmlspecialchars($row['email']); ?></p>
                        <p>Contact: <?php echo htmlspecialchars($row['phone']); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </section>

    <script type="text/javascript">
        let currentImageIndices = {};
        function changeImage(button, direction) {
        const slider = button.closest('.image-slider');
        const images = slider.querySelectorAll('img');
        const sliderIndex = slider.dataset.index;

        if (!currentImageIndices[sliderIndex]) {
                currentImageIndices[sliderIndex] = 0;
        }

        currentImageIndices[sliderIndex] = (currentImageIndices[sliderIndex] + direction + images.length) % images.length;

        images.forEach((img, index) => {
                img.style.display = (index === currentImageIndices[sliderIndex]) ? 'block' : 'none';
        });
        }
        function showSellerDetails(cid) {
            const sellerDetails = document.getElementById('seller-' + cid);
            sellerDetails.style.display = 'block';
        }
    </script>

</body>
</html>

<?php 
} else {     
    header("Location: login.php");     
    exit(); 
} 
?>