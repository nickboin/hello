<?php
include ('session.php');
$sql = "SELECT completato FROM Evento WHERE id = '".$_GET["id"]."' AND tabaccheria = '"
        .$tabaccheria_numero."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';";
$result = mysqli_query($conn, $sql);
if ($result == false) {
    $_SESSION["dettagli_errore"] = "L'ID dell'evento non è trovato nel database";
    $_SESSION["titolo_errore"] = mysqli_error($conn);
    header("Location: error.php");
}
else {
    $togglato=0;
    if (mysqli_fetch_array($result)[0]==0)
        $togglato=1;
    $sql = "UPDATE Evento SET completato=".$togglato." WHERE id = '".$_GET["id"]."' AND tabaccheria = '"
        .$tabaccheria_numero."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';";
    $result = mysqli_query($conn, $sql);
    if ($result == false) {
        $_SESSION["dettagli_errore"] = "L'ID dell'evento non è trovato nel database";
        $_SESSION["titolo_errore"] = mysqli_error($conn);
        header("Location: error.php");
    } else {
        header("Location: ../evento.php?id=".$_GET["id"]);
    }
}
?>