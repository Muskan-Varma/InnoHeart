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

// Fetch crafts uploaded by the logged-in user
$uid = $user['uid'];
$sql = "SELECT title, description, price, quantity, pdate FROM craft WHERE uid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid);
$stmt->execute();
$craftsResult = $stmt->get_result();

$crafts = [];
while ($row = $craftsResult->fetch_assoc()) {
    $crafts[] = $row;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/profile.css" rel="stylesheet">
</head>
<body>
    <form method="post">    
        <section id="playarea" style="padding-left : 100px; padding-right : 100px;">
            <div class="card">
                <strong>Profile</strong><br>
                <p id="name">
                    Name : <?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></p>
                <p id="phone">
                    Phone No. : <?php echo htmlspecialchars($user['phone']); ?></p>
                <p id="email">
                    E-mail : <?php echo htmlspecialchars($user['email']); ?></p>
                <p id="dob">
                    DOB : <?php echo htmlspecialchars($user['dob']); ?></p>
                <p id="gender">
                    Gender : <?php echo htmlspecialchars($user['gender']); ?></p>
                <p class="card-footer" id="rdate">
                    Created On : <?php echo htmlspecialchars(date('F j, Y', strtotime($user['rdate']))); ?></p>
            </div>
            <button type="button" onclick="loadPage('craft.php')"><h3>Sell Craft</h3></button>

            <section id="content-section">
                <h1><label class="heading">Your Uploads :</label></h1><br>
                <?php foreach ($crafts as $row): ?>
                <div class="card">
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
                            <span class="product-category">
                            Posted On : <?php echo htmlspecialchars($row['pdate']); ?>
                            </span>
                            <h4>
                            <a href=""><?php echo htmlspecialchars($row['title']); ?></a>
                            </h4>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                            <div class="product-bottom-details">
                                <div class="product-price">
                                    <?php echo htmlspecialchars($row['price']); ?>
                                    <br>
                                    <small>In Stock : <?php echo htmlspecialchars($row['quantity']); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </section>
        </section>
        <script>
            /* load page */
            function loadPage(page) {
                $.ajax({
                url: page,
                type: "GET",
                success: function (data) {
                    $("#playarea").html(data);
                },
                error: function () {
                    $("playarea").html("<p>An error has occurred</p>");
                },
                });
            }
        </script>
    </form>  
</body>
</html>
