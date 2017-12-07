<?php
include("session.php");
$query_where_tabaccheria="AND tabaccheria = '".$tabaccheria_numero."' AND provincia = '".$tabaccheria_provincia
                        ."' AND comune = '".$tabaccheria_comune."'";
if (!isset($_POST["aams"])||empty($_POST["aams"])||!is_numeric($_POST["aams"])) {
    $_SESSION["dettagli_errore"] = "Codice aams di riferimento non corretto";
    $_SESSION["titolo_errore"] = "Errore interno!";
    header("Location: error.php");    
}
$aams=$_POST["aams"];
if (!isset($_POST["action"])||empty($_POST["action"])) {
    $_SESSION["dettagli_errore"] = "Azione non specificata";
    $_SESSION["titolo_errore"] = "Errore interno!";
    header("Location: error.php");    
}
$azione=$_POST["action"];
if ($azione=="aggiungi") {
    $result=mysqli_query($conn,"SELECT pezzi FROM Magazzino WHERE aams_code='".$aams."' AND tabaccheria = '".$tabaccheria_numero
                ."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';");
    if ($result == false) {
        $_SESSION["dettagli_errore"] = mysqli_error($conn);
        $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
        header("Location: error.php");
    } else {
        if(mysqli_num_rows($result)>0) { //c'è già, somma allora i pezzi
            if (!isset($_POST["pezzi"])||empty($_POST["pezzi"])||!is_numeric($_POST["pezzi"])) {
                $_SESSION["dettagli_errore"] = "Pezzi non specificati";
                $_SESSION["titolo_errore"] = "Errore interno!";
                header("Location: error.php");    
            }
            $pezzi=(int)mysqli_fetch_array($result)[0];
            $pezzi+=(int)$_POST["pezzi"];
            modifica($conn,$aams,$pezzi,$tabaccheria_numero,$tabaccheria_provincia,$tabaccheria_comune);
        } else {    //altrimenti manca, quindi inserisci
            $result=mysqli_query($conn,"INSERT INTO Magazzino(tabaccheria, comune, provincia, aams_code, pezzi) VALUES ('"
                    .$tabaccheria_numero."', '".$tabaccheria_comune."', '".$tabaccheria_provincia."', '".$aams."', '".$_POST["pezzi"]."');");
            if ($result == false) {
                $_SESSION["dettagli_errore"] = mysqli_error($conn);
                $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
                header("Location: error.php");
            }
        }
    }
} else if ($azione=="modifica") {
    if (!isset($_POST["pezzi"])||empty($_POST["pezzi"])||!is_numeric($_POST["pezzi"])) {
        $_SESSION["dettagli_errore"] = "Pezzi non specificati";
        $_SESSION["titolo_errore"] = "Errore interno!";
        header("Location: error.php");    
    }
    modifica($conn,$aams,((int)$_POST["pezzi"]),$tabaccheria_numero,$tabaccheria_provincia,$tabaccheria_comune);
} else if ($azione=="cancella") {
    $result=mysqli_query($conn,"DELETE FROM Magazzino WHERE aams_code='".$aams."' AND tabaccheria = '".$tabaccheria_numero
                ."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';");
    if ($result == false) {
        $_SESSION["dettagli_errore"] = mysqli_error($conn);
        $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
        header("Location: error.php");
    }
} else {}
header('Location: ../magazzino.php');


function modifica($conn,$aams,$pezzi,$tabaccheria_numero,$tabaccheria_provincia,$tabaccheria_comune) {
    $result=mysqli_query($conn,"UPDATE Magazzino SET pezzi='".$pezzi."' WHERE aams_code='".$aams."' AND tabaccheria = '"
                .$tabaccheria_numero."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';");
    if ($result == false) {
        $_SESSION["dettagli_errore"] = mysqli_error($conn);
        $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
        header("Location: error.php");
    }
}
?>