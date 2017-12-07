<?php
include ('session.php');

if ($user_db_row["admin"] == false ) {
   $_SESSION["titolo_errore"] = "Accesso proibito";
   $_SESSION["dettagli_errore"] = "Non sei amministratore della tabaccheria, accesso alla pagina negato.";
	header("Location: php/error.php");
}
?>