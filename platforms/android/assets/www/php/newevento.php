<?php
include ('session.php');
$data = $_POST["data"]." ".((int) $_POST["ora"]).":".((int) $_POST["minuto"]).":00";
$sql = "INSERT INTO `Evento` (`titolo`, `data`, "; //variabili required
//controlla se le variabili non required sono settate e le aggiunge al bisogno
if (isset($_POST["descrizione"])&&$_POST["descrizione"]!="") {
    $sql.="`descrizione`, "; }
//inserisce variabili required
$sql.="`completato`, `tabaccheria`, `provincia`, `comune`) VALUES ('".$_POST["titolo"]."', '".$data."', '"; 
//controlla se le variabili non required sono settate e le aggiunge al bisogno
if (isset($_POST["descrizione"])&&$_POST["descrizione"]!="") {
    $sql.=$_POST["descrizione"]."', '"; }
//aggiunge le rimanenti variabili required
$sql.="0', '".$tabaccheria_numero."', '".$tabaccheria_provincia."', '".$tabaccheria_comune."');";
//query costruita, ora la eseguo
$result = mysqli_query($conn, $sql);
if ($result == false) {
    $_SESSION["titolo_errore"] = "Evento non inserito";
    $_SESSION["dettagli_errore"] = mysqli_error($conn);
    header("Location: error.php");
} else {    //inserito con successo
    $timestamp="";
    if ($_POST["data"]!=date("Y-m-d")) {
        $timestamp="?timestamp=".strtotime($_POST["data"]); }
    header("Location: ../eventi.php".$timestamp);
}
?>