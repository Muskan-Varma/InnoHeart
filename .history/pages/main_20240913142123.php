<?php
session_start();
if (isset($_SESSION['username'])) {
    include 'dbConnect.php';

    // Fetch all crafts and their associated images
    $sql = "SELECT * FROM craft";
    $result = $conn->query($sql);

    $crafts = [];
    while ($row = $result->fetch_assoc()) {
        $cid = $row['cid'];
        $imageSql = "SELECT image_description FROM images WHERE cid = ?";
        $imgStmt = $conn->prepare($imageSql);
        $imgStmt->bind_param("i", $cid);
        $imgStmt->execute();
        $imgResult = $imgStmt->get_result();
        $images = [];
        while ($imgRow = $imgResult->fetch_assoc()) {
            $images[] = $imgRow['image_description'];
        }
        $row['images'] = $images; // Add images to the current craft row
        $crafts[] = $row; // Store the craft row in the array
        $imgStmt->close();
    }
    $conn->close();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Saras</title>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, 
                initial-scale=0.1"
    />
    <link href="../css/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>
    <div class="container">
      <section id="navbar">
        <div id="mySidenav" class="sidenav">
          <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"
            >&times;</a>
          <a href="main.php">Home</a>
          <a href="#" onclick="loadPage('about.php')">About Us</a>
          <a href="#" onclick="loadPage('profile.php')">Profile</a>
          <a href="#" onclick="loadPage('favourites.php')">Favourites & Cart</a>
          <a href="#" onclick="loadPage('settings.php')">Settings</a>
          <a href="logout.php">Log Out</a>
        </div>
        <div id="main">
          <span style="font-size: 30px; cursor: pointer" onclick="openNav()"
            >&#9776;</span
          >
        </div>
      </section>
      <center>
        <div class="row">
          <br /><br /><br />
          <label class="animate-charcter">SARAS</label>
        </div>
      </center>
    </div>

    <h1 style="margin-left:50px;">
      Hello,
      <?php echo htmlspecialchars($_SESSION['firstName']); ?>
    </h1>

    <section id="playarea">  
      <div class="navbar1">
        <div class="dropdown">
          <button class="dropbtn">
            Drawing & Painting
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="#" onclick="filterCrafts('Watercolor Painting')">Watercolor Painting</a>
            <a href="#">Acrylic Painting</a>
            <a href="#">Sketching</a>
          </div>
        </div>
        <div class="dropdown">
          <button class="dropbtn">
            Paper Crafts
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="#">Origami</a>
            <a href="#">Scrapbooking</a>
            <a href="#">Card Making</a>
          </div>
        </div>
        <div class="dropdown">
          <button class="dropbtn">
            Textile Crafts
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="#">Knitting</a>
            <a href="#">Crocheting</a>
            <a href="#">Embroidery</a>
          </div>
        </div>
        <div class="dropdown">
          <button class="dropbtn">
            Jewelry Making
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="#">Beading</a>
            <a href="#">Polymer Clay Jewelry</a>
          </div>
        </div>
        <div class="dropdown">
          <button class="dropbtn">
            Ceramics & Pottery
            <i class="fa fa-caret-down"></i>
          </button>
          <div class="dropdown-content">
            <a href="#">Wheel Throwing</a>
            <a href="#">Hand Building</a>
          </div>
        </div>
      </div>

      <section id="content-section">
         <?php foreach ($crafts as $row): ?>
            <div class="card" data-subcategory="<?php echo htmlspecialchars($row['subcategory']); ?>">
               <!-- Card content goes here -->
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
                              <a href="#" onclick="addToFavourites(this, <?php echo htmlspecialchars($row['cid']); ?>)"><i class="fa fa-heart"></i></a>
                              <a href="#" onclick="shareCraft('<?php echo $row['title']; ?>', window.location.href)"><i class="fas fa-share-nodes"></i></a>
                           </div>
                     </div>
                  </div>
               </div>
            </div>
         <?php endforeach; ?>
      </section>
    </section>

    <section>
      <div id="background-wrap">
        <div class="bubble x1"></div>
        <div class="bubble x2"></div>
        <div class="bubble x3"></div>
        <div class="bubble x4"></div>
        <div class="bubble x5"></div>
        <div class="bubble x6"></div>
        <div class="bubble x7"></div>
        <div class="bubble x8"></div>
        <div class="bubble x9"></div>
        <div class="bubble x10"></div>
      </div>
    </section>

    <script type="text/javascript">
      /*Bubble*/
      function createBubble() {
        const section = document.querySelector("Section");
        const createElement = document.createElement("span");
        var size = Math.random() * 60;

        createElement.style.animation = "animation 6s linear infinite";
        createElement.style.width = 180 + size + "px";
        createElement.style.height = 180 + size + "px";
        createElement.style.left = Math.random() * innerWidth + "px";
        section.appendChild(createElement);

        setTimeout(() => {
          createElement.remove();
        }, 4000);
      }
      setInterval(createBubble, 100);

      /* Navbar */
      function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
      }

      function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
      }

      /* load page */
      function loadPage(page) {
        $.ajax({
          url: page,
          type: "GET",
          success: function (data) {
            $("#playarea").html(data);
          },
          error: function () {
            $("#playarea").html("<p>An error has occurred</p>");
          },
        });
      }

      /* Favourites */
      function addToFavourites(element, cid) {
    // Toggle the 'heart-red' class to change the color of the heart
    element.querySelector('i').classList.toggle('heart-red');
    
    // Send AJAX request to add craft to favourites
    $.ajax({
        url: 'add_to_favourites.php', // The PHP script to handle the database insertion
        type: 'POST',
        data: { craft_id: cid },
        success: function(response) {
            alert(response); // Show success or error message
        },
        error: function() {
            alert("Failed to add to favourites.");
        }
    });
}

      /* Cart */
      function shareCraft(title, url) {
         if (navigator.share) {
            navigator.share({
                  title: title,
                  url: url
            }).then(() => {
                  console.log('Thanks for sharing!');
            }).catch(console.error);
         } else {
            alert('Sharing not supported on this browser.');
         }
      }

      
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

      function filterCrafts(subcategory) {
         const cards = document.querySelectorAll('.card');
         cards.forEach(card => {
            const cardSubcategory = card.getAttribute('data-subcategory');
            if (cardSubcategory === subcategory) {
                  card.style.display = 'block';
            } else {
                  card.style.display = 'none';
            }
         });
      }
    </script>
  </body>
</html>
<?php 
	}
	else{     
		header("Location: login.php");     
		exit();
	} 
?>