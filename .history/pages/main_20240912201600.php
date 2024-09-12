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
        <a href="../index.html" class="back-btn" aria-label="back">
          <ion-icon name="arrow-back-circle-outline">←</ion-icon>
        </a>
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
      function showFavourites(){
        
      }
      /* Cart */
      function share(){

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