<?php
include("session.php");
$query_where_tabaccheria="AND tabaccheria = '".$tabaccheria_numero."' AND provincia = '".$tabaccheria_provincia
                        ."' AND comune = '".$tabaccheria_comune."'";
if (!isset($_POST["action"])||empty($_POST["action"])) {
    $_SESSION["dettagli_errore"] = "Azione non specificata";
    $_SESSION["titolo_errore"] = "Errore interno!";
    header("Location: error.php");    
}
$azione=$_POST["action"];
if ($azione=="aggiungi") {
    if (!isset($_POST["aams"])||empty($_POST["aams"])||!is_numeric($_POST["aams"])) {
        $_SESSION["dettagli_errore"] = "Codice aams non corretto";
        $_SESSION["titolo_errore"] = "Errore interno!";
        header("Location: error.php");    
    }
    if (!isset($_POST["pezzi"])||empty($_POST["pezzi"])||!is_numeric($_POST["pezzi"])) {
        $_SESSION["dettagli_errore"] = "Pezzi non specificati";
        $_SESSION["titolo_errore"] = "Errore interno!";
        header("Location: error.php");    
    }
    $result=mysqli_query($conn,"INSERT INTO Vendita(tabaccheria, comune, provincia, aams_code, pezzi, data) VALUES ('"
            .$tabaccheria_numero."', '".$tabaccheria_comune."', '".$tabaccheria_provincia."', '".$_POST["aams"]."', '".$_POST["pezzi"]
            ."', '".date("Y-m-d H:i:s")."');");
    if ($result == false) {
        $_SESSION["dettagli_errore"] = mysqli_error($conn);
        $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
        header("Location: error.php");
    }
} else if ($azione=="modifica") {
    if (!isset($_POST["id"])||empty($_POST["id"])||!is_numeric($_POST["id"])) {
        $_SESSION["dettagli_errore"] = "ID non corretto";
        $_SESSION["titolo_errore"] = "Errore interno!";
        header("Location: error.php");    
    }
    if (!isset($_POST["pezzi"])||empty($_POST["pezzi"])||!is_numeric($_POST["pezzi"])) {
        $_SESSION["dettagli_errore"] = "Pezzi non specificati";
        $_SESSION["titolo_errore"] = "Errore interno!";
        header("Location: error.php");    
    }
    $result=mysqli_query($conn,"UPDATE Vendita SET pezzi='".$_POST["pezzi"]."' WHERE id='".$_POST["id"]."' AND tabaccheria = '"
                .$tabaccheria_numero."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';");
    if ($result == false) {
        $_SESSION["dettagli_errore"] = mysqli_error($conn);
        $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
        header("Location: error.php");
    }
} else if ($azione=="cancella") {
    if (!isset($_POST["id"])||empty($_POST["id"])||!is_numeric($_POST["id"])) {
        $_SESSION["dettagli_errore"] = "ID non corretto";
        $_SESSION["titolo_errore"] = "Errore interno!";
        header("Location: error.php");    
    }
    $result=mysqli_query($conn,"DELETE FROM Vendita WHERE id='".$_POST["id"]."' AND tabaccheria = '".$tabaccheria_numero
                ."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';");
    if ($result == false) {
        $_SESSION["dettagli_errore"] = mysqli_error($conn);
        $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
        header("Location: error.php");
    }
} else {}
header('Location: ../vendite.php');
?>