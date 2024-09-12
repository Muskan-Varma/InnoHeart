<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Saras Register</title>
    <link rel="stylesheet" href="../css/LR.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php    
        $showAlert = false;  
        $showError = false;  
        $exists=false; 
            
        if($_SERVER["REQUEST_METHOD"] == "POST") { 
            include 'dbConnect.php'; 
            
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            $phone = $_POST["phone"];
            $email = $_POST["email"];
            $dob = $_POST["dob"];
            $gender = $_POST["gender"];

            $username = $_POST["username"];  
            $password = $_POST["password"];  
            $cpassword = $_POST["cpassword"]; 
            $sql = "Select * from users where username='$username'"; 
            
            $result = mysqli_query($conn, $sql); 
            $num = mysqli_num_rows($result);  
            // This sql query is use to check if 
            // the username is already present  
            // or not in our Database 
            if($num == 0) { 
                if(($password == $cpassword) && $exists==false) { 
            
                    $hash = password_hash($password,  PASSWORD_DEFAULT); 
                        
                    // Password Hashing is used here.  
                    $sql = "INSERT INTO `users` ( `uid`,	`firstName`,	`lastName`,	`phone`,	`email`,	`dob`,	`gender`,	`username`,  
                        `pass`, `rdate`) VALUES ('0', '$fname', '$lname', '$phone', '$email', '$dob', '$gender', '$username', '$hash', current_timestamp())";
            
                    $result = mysqli_query($conn, $sql); 
            
                    if ($result) { 
                        $showAlert = true;  
                    } 
                }  
                else {  
                    $showError = "Passwords do not match";  
                }       
            }// end if  
            
        if($num>0)  
        { 
            $exists="Username not available";  
        }  
            
        }//end if    
    ?> 

    <center>
        <div class="container1">
            <div class="row">
				<br><br><br>
                <label class="animate-charcter">SARAS</label>
            </div>
        </div>
		<br><br>
    </center>
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
    <?php 
        if($showAlert) { 
            echo ' <div class="alert alert-success  
                alert-dismissible fade show" role="alert"> 
        
                <strong>Success!</strong> Your account is  
                now created and you can login.  
                <button type="button" class="close"
                    data-dismiss="alert" aria-label="Close">  
                    <span aria-hidden="true">×</span>  
                </button>  
            </div> ';  
        } 
        
        if($showError) { 
        
            echo ' <div class="alert alert-danger  
                alert-dismissible fade show" role="alert">  
            <strong>Error!</strong> '. $showError.'
        
        <button type="button" class="close" 
                data-dismiss="alert aria-label="Close"> 
                <span aria-hidden="true">×</span>  
        </button>  
        </div> ';  
    } 
            
        if($exists) { 
            echo ' <div class="alert alert-danger  
                alert-dismissible fade show" role="alert"> 
        
            <strong>Error!</strong> '. $exists.'
            <button type="button" class="close" 
                data-dismiss="alert" aria-label="Close">  
                <span aria-hidden="true">×</span>  
            </button> 
        </div> ';  
        }
    ?> 
    <form method="post" action="register.php">
    <div class="container">
        <div class="title">Register</div>
        <div class="content">
            <br><br>
            <div class="user-details">
                <div class="input-box">
                    <span class="details">First Name </span>
                    <input type="text" name="fname" placeholder="Enter first name" required>
                </div>
                <div class="input-box">
                    <span class="details">Last Name </span>
                    <input type="text" name="lname" placeholder="Enter last name" required>
                </div>
                <div class="input-box">
                    <span class="details">Mobile No. </span>
                    <input type="number" name="phone" placeholder="Enter your contact" required>
                </div>
                <div class="input-box">
                    <span class="details">E-mail </span>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="input-box">
                    <span class="details">DOB </span>
                    <input type="date" name="dob" required>
                </div>
                <div class="gender-details">
                    <input type="radio" name="gender" id="dot-1" value="male">
                    <input type="radio" name="gender" id="dot-2" value="female">
                    <input type="radio" name="gender" id="dot-3" value="pn">
                    <span class="details">Gender</span>
                    <div class="category">
                        <label for="dot-1">
                            <span class="dot one"></span>
                            <span class="gender">Male</span>
                        </label>
                        <label for="dot-2">
                            <span class="dot two"></span>
                            <span class="gender">Female</span>
                        </label>
                        <label for="dot-3">
                            <span class="dot three"></span>
                            <span class="gender">Prefer not to say</span>
                        </label>
                    </div>
                </div>
                <div class="input-box">
                    <span class="details">Username </span> 
                    <input type="text" name="username" required> 
                </div>
                <div class="input-box">
                    <span class="details">Password </span>  
                    <input type="password" name="password" required>
                </div>
                <div class="input-box">
                    <span class="details">Confirm Password </span> 
                    <input type="password" name="cpassword" required>
                </div>
            </div>
            <div class="button">
                <input type="submit" name="submit" value="Register">
            </div>
            <br>
            <a href="login.php"><u>Proceed to Login ??<u></a>
        </div>
    </div>
    </form>
</body>

</html>