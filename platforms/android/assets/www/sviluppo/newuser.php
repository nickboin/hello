<?php
include ("connetti.php");

$username=$_POST['username'];
$email=$_POST['email'];
$password=$_POST['password'];
$nome=$_POST['nome'];
$cognome=$_POST['cognome'];
$cf=$_POST['cf'];
$immagine=$_POST['immagine'];
$ruolo=$_POST['ruolo'];
$admin=$_POST['admin'];
$datanascita=$_POST['datanascita'];
$tabaccheria=$_POST['tabaccheria'];
$comune=$_POST['comune'];
$provincia=$_POST['provincia'];

$sql="INSERT INTO `utenti` (`username`, `email`, `password`, `nome`, `cognome`, `cf`, `immagine`, `ruolo`, `admin`, `datanascita`, `tabaccheria`, `comune`, `provincia`) VALUES
    ('".$username."', '".$email."', '".$password."', '".$nome."', '".$cognome."', '".$cf."', '".$immagine."', '".$ruolo."', '".$admin."', '".$datanascita."', '".$tabaccheria."', '".$comune."', '".$provincia."');";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Utente ".$username." inserito ";
} else {
    echo " Errore nell'inserimento  : " . $conn -> error ;
}
?>