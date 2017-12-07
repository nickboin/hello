<?php
include ('session.php');

if ($user_db_row["admin"]) {
    $sql = "UPDATE Tabaccheria SET nome=\"".$_GET["nome"]."\", piva=\"".$_GET["piva"]."\"";
    //controlla se le variabili non required sono settate e le aggiunge al bisogno
    if (isset($_GET["localita"])&&$_GET["localita"]!="") {
        $sql.=", localita=\"".$_GET["localita"]."\""; }
    if (isset($_GET["indirizzo"])&&$_GET["indirizzo"]!="") {
        $sql.=", indirizzo=\"".$_GET["indirizzo"]."\""; }
    if (isset($_GET["n_civico"])&&$_GET["n_civico"]!="") {
        $sql.=", n_civico=\"".$_GET["n_civico"]."\""; }
    if (isset($_GET["tel"])&&$_GET["tel"]!="") {
        $sql.=", tel=\"".$_GET["tel"]."\""; }
    if (isset($_GET["fax"])&&$_GET["fax"]!="") {
        $sql.=", fax=\"".$_GET["fax"]."\""; }
    if (isset($_GET["ordine_to_magazzino"])&&$_GET["ordine_to_magazzino"]!="") {
        $sql.=", ordine_to_magazzino=\"1\"";
    } else {
        $sql.=", ordine_to_magazzino=\"0\"";
    } 
    //indica la tabaccheria da modificare
    $sql.=" WHERE numero=\"".$tabaccheria_numero."\" AND provincia=\"".$tabaccheria_provincia."\" AND comune=\"".$tabaccheria_comune."\";";
    
    //query costruita, ora la eseguo
    $result = mysqli_query($conn, $sql);
    if ($result == false) {
        echo $result->mysqli_error();
    } else {
        header("Location: ../tabaccheria.php#updated");
    }
} else {
    $_SESSION["titolo_errore"] = "Accesso proibito";
    $_SESSION["dettagli_errore"] = "Non sei amministratore della tabaccheria, accesso alla pagina negato.";
	header("Location: error.php");
}
?>