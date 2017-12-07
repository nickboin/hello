<?php
include("php/session.php");
if (!isset($_GET["id"])||empty($_GET["id"])||!is_numeric($_GET["id"])) {
    $_SESSION["dettagli_errore"] = "ID non corretto";
    $_SESSION["titolo_errore"] = "Errore interno!";
    header("Location: php/error.php");    
}
$result=mysqli_query($conn,"SELECT descrizione,pezzi,data FROM Tabacco t,Vendita v WHERE v.id='".$_GET["id"]."' "
            ."AND t.aams_code=v.aams_code AND tabaccheria = '".$tabaccheria_numero."' AND provincia = '"
            .$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';");
if ($result == false) {
    $_SESSION["dettagli_errore"] = mysqli_error($conn);
    $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
    header("Location: php/error.php");
}
else {
    if (mysqli_num_rows($result) <= 0) {
        $_SESSION["dettagli_errore"] = "Prodotto non presente nelle vendite";
        $_SESSION["titolo_errore"] ="Errore!";
        header("Location: php/error.php");
    }
}
$row=mysqli_fetch_assoc($result);
$descrizione=$row["descrizione"];
$pezzi=$row["pezzi"];
$data=date("d/m/Y H:i:s",strtotime($row["data"]));
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Eliminazione vendita</title>
        <link rel="shortcut icon" href="images/icon.ico">
        <link rel="stylesheet" href="css/navigation.css">
        <link rel="stylesheet" href="css/gestionale.css">
        <link rel="stylesheet" href="css/base.css">
        <link rel="stylesheet" href="css/forms.css">
    </head>

    <body>
        <!--NAVIGATION MENU-->
        <?php
        $page_active="vendite";
        include("navigation.php");
        ?>
        <div class=box>
            <h1>Eliminazione vendita</h1>
            <h2>Sei sicuro di voler eliminare la vendita del <?php echo $data.' di '.$pezzi.' pezzi di "'.$descrizione; ?>"?</h2>
            <form action="php/editvendita.php" method="POST">
                <input type=hidden name='action' value='cancella'/>
                <input type=hidden name="id" value="<?php echo $_GET["id"]; ?>"/>
                <div class=apply>
                    <input type=button class=tasto value="ANNULLA" onclick="window.location.href='vendite.php';"/>
                    <input type=submit class=tasto value="ELIMINA"/>
                </div>
            </form>
        </div>
        <!--carica per ultimi-->
        <img class=background_img src="images\background2.jpg"/>
    </body>
</html>
