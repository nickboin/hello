<?php
include ('session.php');
$sql = "DELETE FROM Evento WHERE id = '".$_POST["id"]."' AND tabaccheria = '"
        .$tabaccheria_numero."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';";
$result = mysqli_query($conn, $sql);
if ($result == false) {
    $_SESSION["dettagli_errore"] = "L'ID dell'evento non è trovato nel database";
    $_SESSION["titolo_errore"] = mysqli_error($conn);
    header("Location: error.php");
}
else {
    header("Location: ../eventi.php");
}
?>