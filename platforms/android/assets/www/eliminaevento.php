<?php
include("php/session.php");
$evento;
if (isset($_GET["id"])) {
    $result = mysqli_query($conn, "SELECT titolo,data FROM evento WHERE id = '".$_GET["id"]."' AND tabaccheria = '".$tabaccheria_numero
                ."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';");
    if ($result == false) {
        $_SESSION["dettagli_errore"] = mysqli_error($conn);
        $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
        header("Location: php/error.php");
    }
    if(mysqli_num_rows($result) == 1){
        $evento = mysqli_fetch_array($result);
        $data_only_timestamp = strtotime(date("Y-m-d",strtotime($evento["data"])));
    } else {
        $_SESSION["dettagli_errore"] ="Evento non trovato!";
        $_SESSION["titolo_errore"] ="Errore individuazione evento di ID ".$_GET["id"]." nella tabaccheria specificata";
        header("Location: php/error.php");
    }
} else {
    $_SESSION["dettagli_errore"] = "Evento mancante";
    $_SESSION["titolo_errore"] ="L'ID dell'evento non è specificato nei parametri";
    header("Location: php/error.php");
}
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Elimina evento - Tabaccheria online</title>
        <link rel="shortcut icon" href="images/icon.ico">
        <link rel="stylesheet" href="css/navigation.css">
        <link rel="stylesheet" href="css/gestionale.css">
        <link rel="stylesheet" href="css/base.css">
        <link rel="stylesheet" href="css/forms.css">
    </head>
    <body>
        <!--NAVIGATION MENU-->
        <?php
                $page_active="eventi";
                include("navigation.php");
        ?>
        <div class=box>
            <h1>Eliminazione evento</h1>
            <h2>Sei sicuro di voler eliminare l'evento "<?php echo $evento["titolo"]; ?>"?</h2>
            <form action="php/delevento.php" method="POST">
                <input type=hidden name="id" value="<?php echo $_GET["id"]; ?>"/>
                <div class=apply>
                    <input type=button class=tasto value="ANNULLA" onclick="window.location.href='eventi.php?timestamp=<?php echo $data_only_timestamp; ?>';"/> 
                    <input type=submit class=tasto value="ELIMINA"/>
                </div>
            </form>
        </div>
        <!--carica per ultimi-->
        <img class=background_img src="images\background2.jpg"/>
    </body>
</html>
