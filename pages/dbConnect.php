<?php 
   
    $servername = "localhost";  
    $username = "root";  
    $password = ""; 
   
    $database = "saras"; 
   
     // Create a connection  
     $conn = mysqli_connect($servername,  
         $username, $password, $database); 
   
    if($conn) { 
        error_log("Database connected successfully."); 
    }  
    else { 
        die("Error". mysqli_connect_error());  
    }  
?> 