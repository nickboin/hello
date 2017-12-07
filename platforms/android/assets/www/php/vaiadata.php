<?php
if (isset($_GET["data"])) {
    header("Location: ../eventi.php?timestamp=".strtotime($_GET["data"]));
} else {
    session_start();
    $_SESSION["dettagli_errore"] = "La data passata da parametro &egrave; mancante";
    $_SESSION["titolo_errore"] ="Errore nel parsing della data";
    header("Location: error.php");
}
?>