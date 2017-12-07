<?php
include ('connetti.php');

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
            session_start();
            //aggiunge le rimanenti variabili required
            $sql.="1', '".$_SESSION["num_tabaccheria_reg"]."', '".$_SESSION["provincia_reg"]."', '".$_SESSION["comune_reg"]."');";
            //query costruita, ora la eseguo
            $result = mysqli_query($conn, $sql);
            if ($result == false) {
                echo "Non inserito.<br>".$result -> mysqli_error();
            } else {
                $num_tabaccheria = $_SESSION['num_tabaccheria_reg'];
                $provincia = $_SESSION['provincia_reg'];
                $comune = $_SESSION['comune_reg'];
                session_destroy();
                session_start();
                $_SESSION['user'] = $_POST["username"];
                $_SESSION['password'] = hash("sha512",$_POST["password1"]);
                $_SESSION['nome'] = $_POST['nome'];
                $_SESSION['num_tabaccheria'] = $num_tabaccheria;
                $_SESSION['provincia'] = $provincia;
                $_SESSION['comune'] = $comune;
                header("Location: ../confermaRegistrazione.html");
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
?>