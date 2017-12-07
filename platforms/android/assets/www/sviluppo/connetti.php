<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    
    // Create connection
    $conn = new mysqli ( $servername , $username , $password, "Tabaccando" );
    // Check connection
    if ($conn -> connect_error ) {
        die (" Connection failed : " . $conn -> connect_error . "<br>" );
    } else {
        echo "Connesso al database tabaccando, bravo!<br>" ;
    }
?>