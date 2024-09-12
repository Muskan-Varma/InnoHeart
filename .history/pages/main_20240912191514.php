<?php 
    session_start();
    if (isset($_SESSION['username'])) { 
?>
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <title>Saras</title>
    <meta charset="UTF-8" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
    <link href="../css/main.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head> 
<body> 
    <h1>Hello, 
        <?php echo htmlspecialchars($_SESSION['firstName']); ?>
    </h1>
    <div class="container">
        <section id="navbar">
            <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <a href="main.php">Home</a>
                <a href="#" onclick="loadPage('about.php')">About Us</a>
                <a href="#" onclick="loadPage('profile.php')">Profile</a>
                <a href="#" onclick="loadPage('favourites.php')">Favourites & Cart</a>
                <a href="#" onclick="loadPage('settings.php')">Settings</a>
                <a href="logout.php">Log Out</a>
            </div>
            <div id="main">
                <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
            </div>
        </section>
        <center>
            <a href="../index.html" class="back-btn" aria-label="back">
                <ion-icon name="arrow-back-circle-outline">←</ion-icon>
            </a>
            <div class="row">
                <br><br><br>
                <label class="animate-charcter">SARAS</label>
            </div>
        </center>
        <div class="navbar1">
            <div class="dropdown">
                <button class="dropbtn">Decoration 
                <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="#" >Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
            </div>
            <div class="dropdown">
                <button class="dropbtn">Art
                <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
            </div> 
            <div class="dropdown">
                <button class="dropbtn">Craft 
                <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                </div>
            </div> 
        </div>
    </div>

    <section id="content-section">
        <!-- Content loaded dynamically will appear here -->
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
        /* Bubble Animation */
        function createBubble() { 
            const section = document.querySelector("section"); 
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
            document.getElementById("main").style.marginLeft= "0";
        }

        /* Load Page */
        function loadPage(page) {
            $.ajax({
                url: page,
                type: 'GET',
                success: function(data) {
                    $('#content-section').html(data);
                },
                error: function() {
                    $('#content-section').html('<p>An error has occurred</p>');
                }
            });
        }
    </script> 
</body> 
</html> 
<?php 
    }
    else {     
        header("Location: login.php");     
        exit();
    } 
?>