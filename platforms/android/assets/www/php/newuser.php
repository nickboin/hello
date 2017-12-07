<?php
include ('session.php');

if ($user_db_row["admin"]) {
    //verifico se l'username è già presente
    $sql = "SELECT COUNT(*) FROM Utenti WHERE username='".$_POST["username"]."';";
    $result = mysqli_query($conn, $sql);
    if ($result == false) { echo $result->mysqli_error(); }
    else {
        if (mysqli_fetch_array($result)[0] == 0) { //se non c'è già quell'username controllo la password
            if ($_POST["password1"]==$_POST["password2"]) {
                
                $sql = "INSERT INTO `Utenti` (`username`, `email`, `nome`, `password`, "; //variabili required
                //controlla se le variabili non required sono settate e le aggiunge al bisogno
                if (isset($_POST["cognome"])&&$_POST["cognome"]!="") {
                    $sql.="`cognome`, "; }
                if (isset($_POST["cf"])&&$_POST["cf"]!="") {
                    $sql.="`cf`, "; }
                if (isset($_POST["immagine"])&&$_POST["immagine"]!="") {
                    $sql.="`immagine`, "; }
                if (isset($_POST["ruolo"])&&$_POST["ruolo"]!="") {
                    $sql.="`ruolo`, "; }
                if (isset($_POST["datanascita"])&&$_POST["datanascita"]!="") {
                    $sql.="`datanascita`, "; }
                //inserisce variabili required
                $sql.="`admin`, `tabaccheria`, `provincia`, `comune`) VALUES ('".$_POST["username"]."', '".$_POST["email"]."', '".$_POST["nome"]."'
                    , '".hash("sha512",$_POST["password1"])."', '"; 
                //controlla se le variabili non required sono settate e le aggiunge al bisogno
                if (isset($_POST["cognome"])&&$_POST["cognome"]!="") {
                    $sql.=$_POST["cognome"]."', '"; }
                if (isset($_POST["cf"])&&$_POST["cf"]!="") {
                    $sql.=$_POST["cf"]."', '"; }
                if (isset($_POST["immagine"])&&$_POST["immagine"]!="") {
                    $sql.=$_POST["immagine"]."', '"; }
                if (isset($_POST["ruolo"])&&$_POST["ruolo"]!="") {
                    $sql.=$_POST["ruolo"]."', '"; }
                if (isset($_POST["datanascita"])&&$_POST["datanascita"]!="") {
                    $sql.=$_POST["datanascita"]."', '"; }
                //aggiunge le rimanenti variabili required
                $sql.="0', '".$tabaccheria_numero."', '".$tabaccheria_provincia."', '".$tabaccheria_comune."');";
                //query costruita, ora la eseguo
                $result = mysqli_query($conn, $sql);
                if ($result == false) {
                    $_SESSION["titolo_errore"] = "Utente non inserito";
                    $_SESSION["dettagli_errore"] = $result -> mysqli_error();
                    header("Location: error.php");
                } else {    //inserito con successo
                    header("Location: ../manageusers.php?user=".$_POST["username"]."#inserito");
                }
            } else {    //la ridigitazione della password non coincide
                echo "<html><body onload='document.forms[\"redirect\"].submit();'>\n
                <form action='../nuovoadmin.php' method=POST name='redirect'>\n";
                for ($i=0;$i<count($_POST);$i++) {
                    if (key($_POST)!="password1"&&key($_POST)!="password2") {
                        echo "<input type=hidden name='".key($_POST)."' value='".$_POST[key($_POST)]."'/>\n"; }
                    next($_POST);
                }
                echo "<input type=hidden name='pw_error' value='yes'/>\n</form></body></html>";
            }
        } else {    //username non disponibile
            echo "<html><body onload='document.forms[\"redirect\"].submit();'>\n
                <form action='../nuovoadmin.php' method=POST name='redirect'>\n";
            for ($i=0;$i<count($_POST);$i++) {
                echo "<input type=hidden name='".key($_POST)."' value='".$_POST[key($_POST)]."'/>\n";
                next($_POST);
            }
            echo "<input type=hidden name='us_error' value='yes'/>\n</form></body></html>";
        }
    }
} else {
    $_SESSION["titolo_errore"] = "Accesso proibito";
    $_SESSION["dettagli_errore"] = "Non sei amministratore, accesso alla pagina negato.";
	header("Location: error.php");
}
?>