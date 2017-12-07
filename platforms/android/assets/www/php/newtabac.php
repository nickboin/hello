<?php
include ('connetti.php');

if(!isset($_GET["comune"])||$_GET["comune"]=="") {  //se manca il comune allora è il refresh dopo l'inserimento regione/provincia
    header("Location: ../nuovatabac.php?".$_SERVER['QUERY_STRING']);
} else {    //verifico se il comune fa parte della regione e provincia specificarla
    $sql = "SELECT COUNT(*) FROM Regione r,Provincia p,Comune c WHERE c.nome='".$_GET["comune"]."' AND c.provincia=p.sigla AND p.sigla='".$_GET["provincia"]."' AND p.regione=r.nome AND r.nome='".$_GET["regione"]."'";
    $result = mysqli_query($conn, $sql);
    if ($result == false) { echo $result->mysqli_error(); }
    else {
        if (mysqli_fetch_array($result)[0] == 0) { //se non ne fa parte, l'utente ha mezzo sbagliato l'input, verifico la provincia
            $sql = "SELECT COUNT(*) FROM Provincia WHERE sigla='".$_GET["provincia"]."' AND regione='".$_GET["regione"]."'";
            $result = mysqli_query($conn, $sql);
            if ($result == false) { echo $result->mysqli_error(); }
            else {
                if (mysqli_fetch_array($result)[0] == 0) {   //provincia sbagliata, reindirizzo rimuovendo provincia e comune
                    $parametri='regione='.$_GET["regione"];
                    for ($i=0;$i<count($_GET);$i++) {
                        if(key($_GET)!="regione"&&key($_GET)!="provincia"&&key($_GET)!="comune"&&$_GET[key($_GET)]!="")
                            $parametri.="&".key($_GET)."=".$_GET[key($_GET)];
                        next($_GET);
                    }
                    header("Location: ../nuovatabac.php?".$parametri);
                }
                else {   //comune sbagliato, reindirizzo rimuovendo il comune
                    $parametri='regione='.$_GET["regione"];
                    for ($i=0;$i<count($_GET);$i++) {
                        if(key($_GET)!="regione"&&key($_GET)!="comune"&&$_GET[key($_GET)]!="")
                            $parametri.="&".key($_GET)."=".$_GET[key($_GET)];
                        next($_GET);
                    }
                    header("Location: ../nuovatabac.php?".$parametri);
                }
            }
        } else {    //inserimento di regione, provincia e comune corretto, procedo con l'inserimento
            $sql = "INSERT INTO `tabaccheria` (`numero`, `piva`, `nome`, "; //variabili required
            //controlla se le variabili non required sono settate e le aggiunge al bisogno
            if (isset($_GET["localita"])&&$_GET["localita"]!="") {
                $sql.="`localita`, "; }
            if (isset($_GET["indirizzo"])&&$_GET["indirizzo"]!="") {
                $sql.="`indirizzo`, "; }
            if (isset($_GET["n_civico"])&&$_GET["n_civico"]!="") {
                $sql.="`n_civico`, "; }
            if (isset($_GET["telefono"])&&$_GET["telefono"]!="") {
                $sql.="`tel`, "; }
            if (isset($_GET["fax"])&&$_GET["fax"]!="") {
                $sql.="`fax`, "; }
            //inserisce variabili required
            $sql.="`comune`, `provincia`, `ordine_to_magazzino`) VALUES ('".$_GET["numero"]."', '".$_GET["piva"]."', '".$_GET["nome"]."', '"; 
            //controlla se le variabili non required sono settate e le aggiunge al bisogno
            if (isset($_GET["localita"])&&$_GET["localita"]!="") {
                $sql.=$_GET["localita"]."', '"; }
            if (isset($_GET["indirizzo"])&&$_GET["indirizzo"]!="") {
                $sql.=$_GET["indirizzo"]."', '"; }
            if (isset($_GET["n_civico"])&&$_GET["n_civico"]!="") {
                $sql.=$_GET["n_civico"]."', '"; }
            if (isset($_GET["telefono"])&&$_GET["telefono"]!="") {
                $sql.=$_GET["telefono"]."', '"; }
            if (isset($_GET["fax"])&&$_GET["fax"]!="") {
                $sql.=$_GET["fax"]."', '"; }
            //aggiunge le rimanenti variabili required
            $sql.=$_GET["comune"]."', '".$_GET["provincia"]."', '1');";
            //query costruita, ora la eseguo
            $result = mysqli_query($conn, $sql);
            if ($result == false) {
                header("Location: ../nuovatabac.php?error=yes&".$_SERVER["QUERY_STRING"]);
            } else {
                session_destroy();
                session_start();
                $_SESSION["nome_tabaccheria_reg"]=$_GET["nome"];
                $_SESSION["num_tabaccheria_reg"]=$_GET["numero"];
                $_SESSION["comune_reg"]=$_GET["comune"];
                $_SESSION["provincia_reg"]=$_GET["provincia"];
                header("Location: ../nuovoadmin.php");
            }
        }
    }
}
?>