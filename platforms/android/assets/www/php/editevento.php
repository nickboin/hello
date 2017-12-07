<?php
include ('session.php');
$data = $_POST["data"]." ".((int) $_POST["ora"]).":".((int) $_POST["minuto"]).":00";
$sql = "UPDATE Evento SET titolo='".$_POST["titolo"]."', ";
if (isset($_POST["descrizione"])&&$_POST["descrizione"]!="") {
    $sql.="descrizione='".$_POST["descrizione"]."', ";
} else { $sql.="descrizione=NULL, "; }
$sql .= "data='".$data."' WHERE id = '".$_POST["id"]."' AND tabaccheria = '"
        .$tabaccheria_numero."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';";
$result = mysqli_query($conn, $sql);
if ($result == false) {
    $_SESSION["dettagli_errore"] = "L'ID dell'evento non è trovato nel database";
    $_SESSION["titolo_errore"] = mysqli_error($conn);
    header("Location: error.php");
}
else {
    header("Location: ../evento.php?id=".$_POST["id"]);
}
?>