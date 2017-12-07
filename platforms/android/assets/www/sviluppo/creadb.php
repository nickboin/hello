<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    
    // Create connection
    $conn = new mysqli ( $servername , $username , $password );
    // Check connection
    if ($conn -> connect_error ) {
        die (" Connection failed : " . $conn -> connect_error . "<br>" );
    } else {
        echo "Connesso al dbms, bravo!<br>" ;
    }
    
    // Create database
    $db = "Tabaccando";
    $sql = "CREATE DATABASE ".$db;
    if ($conn -> query ( $sql ) == TRUE ) {
        echo "Database ".$db." created successfully<br>";
    } else {
        $table = "Utenti";
        if( mysql_num_rows( mysql_query("SHOW TABLES LIKE '".$table."'"))){
            echo "Table ".$table." in database ".$db." already exist<br>";
        } else {
            echo "Error creating database ".$db."<br>";
        }
    }
?>