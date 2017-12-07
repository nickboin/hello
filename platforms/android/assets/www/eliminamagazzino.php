<?php
include("php/session.php");
if (!isset($_GET["aams"])||empty($_GET["aams"])||!is_numeric($_GET["aams"])) {
    $_SESSION["dettagli_errore"] = "Codice aams di riferimento non corretto";
    $_SESSION["titolo_errore"] = "Errore interno!";
    header("Location: php/error.php");    
}
$result=mysqli_query($conn,"SELECT descrizione,pezzi FROM Tabacco,Magazzino WHERE Tabacco.aams_code='".$_GET["aams"]."' "
            ."AND Tabacco.aams_code=Magazzino.aams_code AND tabaccheria = '".$tabaccheria_numero."' AND provincia = '"
            .$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';");
if ($result == false) {
    $_SESSION["dettagli_errore"] = mysqli_error($conn);
    $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
    header("Location: php/error.php");
}
else {
    if (mysqli_num_rows($result) <= 0) {
        $_SESSION["dettagli_errore"] = "Prodotto non presente nel tuo magazzino";
        $_SESSION["titolo_errore"] ="Errore!";
        header("Location: php/error.php");
    }
}
$row=mysqli_fetch_assoc($result);
$descrizione=$row["descrizione"];
$pezzi=$row["pezzi"];
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Eliminazione prodotto magazzino</title>
        <link rel="shortcut icon" href="images/icon.ico">
        <link rel="stylesheet" href="css/navigation.css">
        <link rel="stylesheet" href="css/gestionale.css">
        <link rel="stylesheet" href="css/base.css">
        <link rel="stylesheet" href="css/forms.css">
    </head>

    <body>
        <!--NAVIGATION MENU-->
        <?php
        $page_active="magazzino";
        include("navigation.php");
        ?>
        <div class=box>
            <h1>Eliminazione prodotto</h1>
            <h2>Sei sicuro di voler eliminare <?php echo $pezzi; ?> pezzi di "<?php echo $descrizione; ?>" dal magazzino?</h2>
            <form action="php/editmagazzino.php" method="POST">
                <input type=hidden name='action' value='cancella'/>
                <input type=hidden name="aams" value="<?php echo $_GET["aams"]; ?>"/>
                <div class=apply>
                    <input type=button class=tasto value="ANNULLA" onclick="window.location.href='magazzino.php';"/>
                    <input type=submit class=tasto value="ELIMINA"/>
                </div>
            </form>
        </div>
        <!--carica per ultimi-->
        <img class=background_img src="images\background2.jpg"/>
    </body>
</html>
