<?php 
   
    $servername = "localhost";  
    $username = "root";  
    $password = ""; 
   
    $database = "saras"; 
   
     // Create a connection  
     $conn = mysqli_connect($servername,  
         $username, $password, $database); 
   
    if($conn) { 
        echo "success";  
    }  
    else { 
        die("Error". mysqli_connect_error());  
    }  
?> 

<?php
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "your_dbname";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>