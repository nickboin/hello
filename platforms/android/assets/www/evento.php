<?php
include("php/session.php");
if (!isset($_GET["id"])) {
    $_SESSION["dettagli_errore"] = "Evento mancante";
    $_SESSION["titolo_errore"] ="L'ID dell'evento non è specificato nei parametri";
    header("Location: php/error.php");
}
$result = mysqli_query($conn,"SELECT * FROM evento WHERE id = '".$_GET["id"]."' AND tabaccheria = '".$tabaccheria_numero."' AND provincia = '"
                            .$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';");
$evento;
if ($result==false) {
    $_SESSION["dettagli_errore"] = "L'ID dell'evento non è trovato nel database";
    $_SESSION["titolo_errore"] = mysqli_error($conn);
    header("Location: php/error.php");
} else {
    $evento = mysqli_fetch_assoc($result);
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Evento - Tabaccheria Online</title>
        <link rel="shortcut icon" href="images/icon.ico">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- per icone -->
        <link rel="stylesheet" href="css/navigation.css">
        <link rel="stylesheet" href="css/gestionale.css">
        <link rel="stylesheet" href="css/base.css">
    </head>

    <body>
        <!--NAVIGATION MENU-->
        <?php
            $page_active="eventi";
            include("navigation.php");
        ?>
        <div class=box style="padding-left:20px;line-height:2;">
            <h1><a href="" onclick="window.history.back();" class="fa">&#xf060;</a> &nbsp; Dettagli evento: <?php echo $evento["titolo"]; ?></h1>
            
            <a href='modificaevento.php?id=<?php echo $_GET["id"]; ?>' class="fa fa-pencil-square-o"> Modifica</a> &nbsp; &nbsp; <a 
                href='eliminaevento.php?id=<?php echo $_GET["id"]; ?>' class="fa fa-trash-o"> Cancella</a>
            <br/><br/>
            <b>Data</b>: <?php echo date("d/m/Y", strtotime($evento["data"])); ?><br/>
            <b>Ora</b>: <?php echo date("H:i", strtotime($evento["data"])); ?><br/>
            <b>Descrizione</b>: <?php echo $evento["descrizione"]; ?><br/>
            <b>Completato</b>: <?php if ($evento["completato"]==0) { echo "No"; } else { echo "Si"; } ?>  
                <a href='php/toggleevento.php?id=<?php echo $_GET["id"]; ?>' class="fa fa-retweet" style='font-size:12px'> Cambia</a><br/>
            <b>ID</b>: <?php echo $evento["id"]; ?>
        </div>
        <!--carica per ultimi-->
        <img class=background_img src="images\background2.jpg">
    </body>
</html>