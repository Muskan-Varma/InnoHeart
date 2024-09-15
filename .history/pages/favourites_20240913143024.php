<?php
session_start();
if (isset($_SESSION['username'])) {
    include 'dbConnect.php';

    // Fetch the user's favourites crafts from the favourites table
    $sql = "
        SELECT c.*, i.image_description 
        FROM favourites f
        JOIN craft c ON f.cid = c.cid
        LEFT JOIN images i ON c.cid = i.cid
        WHERE f.username = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $_SESSION['username']);
    $stmt->execute();
    $result = $stmt->get_result();

    $favourites = [];
    while ($row = $result->fetch_assoc()) {
        $cid = $row['cid'];

        // Check if the craft already exists in the array
        if (!isset($favourites[$cid])) {
            $favourites[$cid] = $row;
            $favourites[$cid]['images'] = [];
        }

        // Add image to the craft if available
        if ($row['image_description']) {
            $favourites[$cid]['images'][] = $row['image_description'];
        }
    }

    $stmt->close();
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Favourites</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1>Your Favourite Crafts</h1>
        <section id="content-section">
            <?php if (empty($favourites)): ?>
                <p>No favourites added yet.</p>
            <?php else: ?>
                <?php foreach ($favourites as $row): ?>
                    <div class="card" data-subcategory="<?php echo htmlspecialchars($row['subcategory']); ?>">
                        <div class="product-card">
                            <div class="badge"><?php echo htmlspecialchars($row['category']); ?></div>
                            <div class="product-tumb">
                                <?php if (!empty($row['images'])): ?>
                                <div class="image-slider" data-index="<?php echo $row['cid']; ?>">
                                    <?php foreach ($row['images'] as $index => $image): ?>
                                        <img src="uploads/<?php echo htmlspecialchars($image); ?>" alt="" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                                    <?php endforeach; ?>
                                    <?php if (count($row['images']) > 1): ?>
                                        <button class="prev" onclick="changeImage(this, -1)">&#10094;</button>
                                        <button class="next" onclick="changeImage(this, 1)">&#10095;</button>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="product-details">
                                <span class="product-category">Posted On: <?php echo htmlspecialchars($row['pdate']); ?></span>
                                <h4><a href="#"><?php echo htmlspecialchars($row['title']); ?></a></h4>
                                <p><?php echo htmlspecialchars($row['description']); ?></p>
                                <div class="product-bottom-details">
                                    <div class="product-price">
                                        <?php echo htmlspecialchars($row['price']); ?>
                                        <br>
                                        <small>In Stock: <?php echo htmlspecialchars($row['quantity']); ?></small>
                                    </div>
                                    <div class="product-links">
                                        <br>
                                        <a href="#" class="fa fa-heart heart-red"></a> <!-- Display heart as red to indicate it's in favourites -->
                                        <a href="#" onclick="share()"><i class="fas fa-share-nodes"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </div>
    <script>
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

        function share() {
            // Add sharing functionality
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
