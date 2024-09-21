<?php
session_start();
include 'dbConnect.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's username and uid from the session
$username = $_SESSION['username'];

// Fetch user id (uid) from the database
$sql = "SELECT uid FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$uid = $user['uid'];
$stmt->close();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    
    // Insert craft details into the craft table
    $sql = "INSERT INTO craft (title, description, category, subcategory, price, quantity, uid) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdisi", $title, $description, $category, $subcategory, $price, $quantity, $uid);

    if ($stmt->execute()) {
        $cid = $stmt->insert_id; // Get the last inserted craft id

        // Handle image uploads
        $uploadDirectory = "uploads/";

        // Check if the directory exists, if not, create it
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            // Get the full file name including extension
            $fileName = basename($_FILES['images']['name'][$key]);
            
            // Set the target file path
            $targetFilePath = $uploadDirectory . $fileName;

            // Move the uploaded file to the server
            if (move_uploaded_file($tmpName, $targetFilePath)) {
                // Insert image details into the images table
                $sql = "INSERT INTO images (cid, image_description) VALUES (?, ?)";
                $imgStmt = $conn->prepare($sql);
                
                // Bind the full file name (including extension) as the image description
                $imgStmt->bind_param("is", $cid, $fileName);
                $imgStmt->execute();
                $imgStmt->close();  // Close the image statement after each image insertion
            } else {
                echo "<script>alert('Failed to upload image: " . $fileName . "');</script>";
            }
        }


        echo "<script>
                alert('Craft and images uploaded successfully!');
                window.location.href = 'main.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Craft</title>
    <link href="../css/craft.css" rel="stylesheet">
</head>
<body>
    <section id="playarea" style="padding-left : 100px; padding-right : 100px;">
        <h2>Upload Craft</h2>
        <form action="craft.php" method="post" enctype="multipart/form-data">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" required><br><br>

            <label for="description">Description:</label><br>
            <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

            <label for="category">Category:</label><br>
            <select id="category" name="category" required onchange="updateSubcategories()">
                <option value="Drawing and Painting">Drawing and Painting</option>
                <option value="Paper Crafts">Paper Crafts</option>
                <option value="Textile Crafts">Textile Crafts</option>
                <option value="Jewelry Making">Jewelry Making</option>
                <option value="Ceramics and Pottery">Ceramics and Pottery</option>
            </select><br><br>

            <label for="subcategory">Subcategory:</label><br>
            <select id="subcategory" name="subcategory" required>
                <!-- Subcategories will be populated here based on the category -->
            </select><br><br>

            <label for="price">Price:</label><br>
            <input type="number" id="price" name="price" step="0.01" required><br><br>

            <label for="quantity">Quantity:</label><br>
            <input type="number" id="quantity" name="quantity" required><br><br>

            <label for="images">Upload Images:</label><br>
            <input type="file" id="images" name="images[]" multiple="multiple" required><br><br>

            <input type="submit" value="Add Craft">
        </form>
    </section>

    <script>
        const subcategories = {
            "Drawing and Painting": ["Watercolor Painting", "Acrylic Painting", "Sketching"],
            "Paper Crafts": ["Origami", "Scrapbooking", "Card Making"],
            "Textile Crafts": ["Knitting", "Crocheting", "Embroidery"],
            "Jewelry Making": ["Beading", "Polymer Clay Jewelry"],
            "Ceramics and Pottery": ["Wheel Throwing", "Hand Building"]
        };

        function updateSubcategories() {
            const category = document.getElementById('category').value;
            const subcategorySelect = document.getElementById('subcategory');
            subcategorySelect.innerHTML = '';

            if (subcategories[category]) {
                subcategories[category].forEach(function(subcat) {
                    const option = document.createElement('option');
                    option.value = subcat;
                    option.text = subcat;
                    subcategorySelect.appendChild(option);
                });
            }
        }

        // Initialize subcategories on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateSubcategories();
        });
    </script>
</body>
</html>
