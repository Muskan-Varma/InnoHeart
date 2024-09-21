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
            
        if ($_SERVER["REQUEST_METHOD"] == "POST") { 
            include 'dbConnect.php'; 
            
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
            $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
            $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            $dob = mysqli_real_escape_string($conn, $_POST["dob"]);
            $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
            $username = mysqli_real_escape_string($conn, $_POST["username"]);  
            $password = mysqli_real_escape_string($conn, $_POST["password"]);  
            $cpassword = mysqli_real_escape_string($conn, $_POST["cpassword"]); 
            
            $sql = "SELECT * FROM users WHERE username='$username'"; 
            $result = mysqli_query($conn, $sql); 
            $num = mysqli_num_rows($result);  
            
            if ($num == 0) { 
                if ($password == $cpassword) { 
                    $hash = password_hash($password, PASSWORD_DEFAULT); 
                    
                    $sql = "INSERT INTO users (firstName, lastName, phone, email, dob, gender, username, pass, rdate) 
                            VALUES ('$fname', '$lname', '$phone', '$email', '$dob', '$gender', '$username', '$hash', current_timestamp())";
                    $result = mysqli_query($conn, $sql); 
            
                    if ($result) { 
                        $showAlert = true;  
                    } else {
                        $showError = "Registration failed: " . mysqli_error($conn);
                    }
                } else {  
                    $showError = "Passwords do not match";  
                }       
            } else { 
                $exists = "Username not available";  
            }
            
            mysqli_close($conn);
        }    
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
        if ($showAlert) { 
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert"> 
                <strong>Success!</strong> Your account is now created and you can login.  
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">  
                    <span aria-hidden="true">×</span>  
                </button>  
            </div>';  
        } 
        
        if ($showError) { 
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">  
                <strong>Error!</strong> '. $showError .'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                    <span aria-hidden="true">×</span>  
                </button>  
            </div>';  
        } 
            
        if ($exists) { 
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"> 
                <strong>Error!</strong> '. $exists .'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">  
                    <span aria-hidden="true">×</span>  
                </button> 
            </div>';  
        }
    ?> 

    <form method="post" action="register.php"><div class="container">
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
            </form>
            <a href="login.php"><u>Proceed to Login ??<u></a>
        </div>
    </div>
</body>

</html>