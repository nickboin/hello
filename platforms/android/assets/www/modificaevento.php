<?php
include("php/session.php");
$evento;
if (isset($_GET["id"])) {
    $result = mysqli_query($conn, "SELECT * FROM evento WHERE id = '".$_GET["id"]."' AND tabaccheria = '".$tabaccheria_numero
                ."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';");
    if ($result == false) {
        $_SESSION["dettagli_errore"] = mysqli_error($conn);
        $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
        header("Location: php/error.php");
    }
    if(mysqli_num_rows($result) == 1){
        $evento = mysqli_fetch_array($result);
        $data_timestamp = strtotime($evento["data"]);
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
        <title>Modifica evento - Tabaccheria Online</title>
        <link rel="shortcut icon" href="images/icon.ico">
        <link rel="stylesheet" href="css/navigation.css">
        <link rel="stylesheet" href="css/gestionale.css">
        <link rel="stylesheet" href="css/tableforms.css">
        <link rel="stylesheet" href="css/forms.css">
        <link rel="stylesheet" href="css/base.css">
    </head>

    <body>
        <!--NAVIGATION MENU-->
        <?php
            $page_active="eventi";
            include("navigation.php");
            $data = isset($_GET['timestamp']) ? date('Y-m-d',$_GET['timestamp']) : date('Y-m-d');
        ?>
        <div class=box>
            <h1>Modifica evento</h1>
            <form action="php/editevento.php" method="POST">
                <input type=hidden name="id" value="<?php echo $evento["id"]; ?>"/>
                <table id="dati">
                    <tr>
                        <td><b>Titolo</b>:</td>
                        <td>
                            <input type=text maxlength="50" name="titolo" style="width:100%" required value="<?php echo $evento["titolo"]; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Descrizione</b>:</td>
                        <td>
                            <input type=text name="descrizione" style="width:100%" value="<?php echo $evento["descrizione"]; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Data</b>:</td>
                        <td>
                            <input type=date name="data" value="<?php echo date("Y-m-d",$data_timestamp);?>"/> &nbsp; 
                            <b>Ora</b>: &nbsp; <input type=number max=23 min=0 name="ora" required value="<?php echo date("H",$data_timestamp); ?>"
                               /><b>:</b><input type=number max=59 min=0 name="minuto" required value="<?php echo date("i",$data_timestamp); ?>"/>
                        </td>
                    </tr>
                </table>
                <div class=apply>
                    <input type=button class=tasto value='ANNULLA' onclick="window.location.href='eventi.php?timestamp=<?php echo strtotime(date("Y-m-d",$data_timestamp)); ?>';" />
                    <input type=submit class=tasto value='MODIFICA' />
                </div>
            </form>
        </div>
        <!--carica per ultimi-->
        <img class=background_img src="images\background2.jpg">
    </body>
</html>
