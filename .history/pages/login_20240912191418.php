<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Saras Login</title>
    <link rel="stylesheet" href="../css/LR.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php
        session_start(); 
        include "dbConnect.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            function validate($data) {       
                $data = trim($data);       
                $data = stripslashes($data);       
                $data = htmlspecialchars($data);       
                return $data;    
            }    
            $uname = validate($_POST['username']);    
            $pass = validate($_POST['pass']);    

            if (empty($uname)) {        
                header("Location: login.php?error=User Name is required");        
                exit();    
            }
            else if (empty($pass)) {        
                header("Location: login.php?error=Password is required");        
                exit();    
            }
            else {        
                $sql = "SELECT * FROM users WHERE username='$uname'";        
                $result = mysqli_query($conn, $sql);        

                if (mysqli_num_rows($result) === 1) {            
                    $row = mysqli_fetch_assoc($result);            
                    if ($row && password_verify($pass, $row['pass'])) {
                        $_SESSION['username'] = $row['username'];                
                        $_SESSION['firstName'] = $row['firstName'];                
                        $_SESSION['lastName'] = $row['lastName'];                
                        header("Location: main.php");                
                        exit();            
                    }
                    else {                
                        header("Location: login.php?error=Incorrect User name or password");                
                        exit();            
                    }        
                }
                else {            
                    header("Location: login.php?error=Incorrect User name or password");            
                    exit();        
                }    
            }
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
    <form method="post" action="login.php">
        <div class="container">
            <div class="title">Login</div><br>
            <div class="content">
                <br><br>
                <?php if (isset($_GET['error'])) { ?>            
                    <p class="error">
                        <?php echo $_GET['error']; ?>
                    </p>        
                <?php } ?> 
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Username </span> 
                        <input type="text" name="username" required> 
                    </div>
                    <div class="input-box">
                        <span class="details">Password </span>  
                        <input type="password" name="pass" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" name="submit" value="Login">
                </div>
            </div>
        </div>
    </form>
</body>
</html>