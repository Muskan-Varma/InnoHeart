<?php
session_start();
if (isset($_SESSION['username'])) {
    include 'dbConnect.php';

    // Fetch all favourite crafts and uploader details
    $sql = "SELECT f.craft_id, c.*, u.firstName, u.email, u.phone 
    FROM favourites f
    JOIN craft c ON f.craft_id = c.cid
    JOIN users u ON c.uploader_id = u.uid
    WHERE f.user_id = ?";

$sql = "SELECT c.cid, c.title, c.description, c.price, c.quantity, c.pdate, u.firstName, u.email, u.phone
FROM favourites f
JOIN craft c ON f.cid = c.cid
JOIN users u ON c.username = u.username
WHERE f.username = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['uid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $crafts = [];
    while ($row = $result->fetch_assoc()) {
        $crafts[] = $row;
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <section id="content-section">
        <?php foreach ($crafts as $row): ?>
        <div class="card">
            <div class="product-card">
                <div class="badge"><?php echo htmlspecialchars($row['category']); ?></div>
                <div class="product-tumb">
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="">
                </div>
                <div class="product-details">
                    <span class="product-category">Posted On: <?php echo htmlspecialchars($row['pdate']); ?></span>
                    <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <div class="product-bottom-details">
                        <div class="product-price">
                            Price: <?php echo htmlspecialchars($row['price']); ?>
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
