<?php
include ('session.php');
date_default_timezone_set('Europe/Rome');
$data_corrente = date('Y-m-d H:i:s');

$sql = "INSERT INTO `ordine` (`tabaccheria`, `provincia`, `comune`, `data_creazione`, `data_aggiornamento`, `data_spedizione`)
	VALUES ('".$tabaccheria_numero."', '".$tabaccheria_provincia."', '".$tabaccheria_comune."' 
	, '".$data_corrente."', '".$data_corrente."', '".$_POST["data"]."');";
$result = mysqli_query($conn, $sql);
if ($result == false) {
	$_SESSION["titolo_errore"] = "Ordine non creato";
	$_SESSION["dettagli_errore"] = "Errore esecuzione query SQL!\nDettagli:\n".mysqli_error($conn);
	header("Location: error.php");
} else {    //inserito con successo
	header("Location: ../modificaordine.php?num=".mysqli_insert_id($conn));
}
?>