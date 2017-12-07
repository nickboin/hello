<?php
include ('connetti.php');
session_start();
$logged_user = $_SESSION['user'];
$logged_user_nome = $_SESSION['nome'];
$tabaccheria_numero = $_SESSION['num_tabaccheria'];
$tabaccheria_provincia = $_SESSION['provincia'];
$tabaccheria_comune = $_SESSION['comune'];

$query = "SELECT * FROM Tabaccheria WHERE numero = '".$tabaccheria_numero."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';";
$result = mysqli_query($conn, $query);
if ( !mysqli_num_rows($result) == 1 )   //tabaccheria non trovata nel database
   echo ("Errore strano, tabaccheria associata all'utente ".$logged_user_nome." non trovata.");
$tabaccheria_row = mysqli_fetch_array($result); //per usi futuri in_page
$tabaccheria_nome = $tabaccheria_row["nome"];

//verifica l'effettivo login
$query = "SELECT * FROM Utenti WHERE username = '".$logged_user."' AND password = '".$_SESSION['password']."';";
$result = mysqli_query($conn, $query);
if ( !mysqli_num_rows($result) == 1 ) {  //utente non trovato nel database quindi non loggato, o per qualche motivo login scorretto
   session_destroy();
   header("location:login.php?login=error");
}
$user_db_row = mysqli_fetch_array($result); //per usi futuri in_page
?>