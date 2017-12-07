<?php
include("connetti.php");
$sql="DROP DATABASE `tabaccando`;";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Database cancellato";
} else {
    echo " Problemi nella cancellazione del database : " . $conn -> error ;
}
?>