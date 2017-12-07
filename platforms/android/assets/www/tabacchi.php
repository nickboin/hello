<?php
   include("php/session.php");
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Tabacchi</title>
        <link rel="shortcut icon" href="images/icon.ico">
        <link rel="stylesheet" href="css/navigation.css">
        <link rel="stylesheet" href="css/gestionale.css">
        <link rel="stylesheet" href="css/base.css">
        <link rel="stylesheet" href="css/forms.css">
        <link rel="stylesheet" href="css/placeholder.css">
        <?php if(isset($_GET["tipo"])&&$_GET["tipo"]=="aams"&&isset($_GET["cerca"])&&!empty($_GET["cerca"])) {
                echo "<link rel='stylesheet' href='css/tableforms.css'>"; }
                else { echo "<link rel='stylesheet' href='css/tableelenchi.css'>"; } ?>
        <style>
        <?php if(isset($_GET["tipo"])&&$_GET["tipo"]=="aams"&&isset($_GET["cerca"])&&!empty($_GET["cerca"])) {
                echo "table { width: 60%; margin-left: 20%; }\n td { padding: 20px; }"; }
                else { echo "td { text-align: center; }"; } ?>
        </style>
    </head>

    <body>
        <!--NAVIGATION MENU-->
        <?php
                $page_active="tabacchi";
                include("navigation.php");
        ?>
        <div class=box>
            <h1>Tabacchi</h1>
            <form action="tabacchi.php" method=GET>
                <input type=text pattern="\d*" name="cerca" id='cerca' style="width:70%;" placeholder="Cerca" <?php
                    if(isset($_GET["cerca"])&&!empty($_GET["cerca"])) { echo "value='".$_GET["cerca"]."'"; } ?> />
                <select id="tipo" name="tipo" onchange="cambioTipo();">
                    <option value="aams" <?php if(isset($_GET["tipo"])&&$_GET["tipo"]!="aams") {} else { echo "selected"; }?> >Codice AAMS</option>
                    <option value="desc" <?php if(isset($_GET["tipo"])&&$_GET["tipo"]=="desc") { echo "selected"; }?> >Descrizione</option>
                </select>
                <input type=submit value="Cerca"/>
            </form>
            <br/>
            <?php
                $sql = "SELECT ";
                if(isset($_GET["cerca"])&&!empty($_GET["cerca"])) {
                    if(isset($_GET["tipo"])&&$_GET["tipo"]=="aams") {
                        if(is_numeric($_GET["cerca"])) {
                            $sql.="* FROM tabacco WHERE aams_code = '".$_GET["cerca"]."';";
                        } else {
                            $_SESSION["dettagli_errore"] = "Parametro di ricerca codice aams non numerico!";
                            $_SESSION["titolo_errore"] ="Errore nella ricerca!";
                            header("Location: php/error.php");
                        }
                    } else if (isset($_GET["tipo"])&&$_GET["tipo"]=="desc") {
                        $sql.="aams_code, descrizione FROM tabacco WHERE descrizione LIKE '%".$_GET["cerca"]."%';";
                    } else {
                        $_SESSION["dettagli_errore"] = "Parametro di tipo di ricerca nei tabacchi non settato correttamente";
                        $_SESSION["titolo_errore"] ="Errore nella ricerca!";
                        header("Location: php/error.php");
                    }
                } else {
                    $sql.="aams_code, descrizione FROM tabacco;";
                }
                $result = mysqli_query($conn, $sql);
                if ($result == false) {
                    $_SESSION["dettagli_errore"] = mysqli_error($conn);
                    $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
                    header("Location: php/error.php");
                }
                else {
                    if(isset($_GET["tipo"])&&$_GET["tipo"]=="aams"&&isset($_GET["cerca"])&&!empty($_GET["cerca"])) {
                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            echo "<h2 style='margin-left:10%;'>".$row["descrizione"]."</h2><table><tr><td colspan='2'>".$row["tipologia"]."</td></tr>
                                    <tr><td><b>Codice AAMS</b>: ".$row["aams_code"]."</td><td><b>Pacchetto da ".$row["pacchetto"]." ".$row["tipologia"]."</b></td></tr>
                                    <tr><td><b>Prezzo unitario</b>: ".$row["prezzo_unitario"]." &euro;</td><td><b>Prezzo stecca (".$row["qta_stecca"]
                                    ." pz.)</b>: ".$row["prezzo_stecca"]." &euro;</td></tr>";
                            if ((isset($row["barcode"])&&!empty($row["barcode"]))||(isset($row["barcode_stecca"])&&!empty($row["barcode_stecca"])))
                            {   echo "<tr><td>";
                                if (isset($row["barcode"])&&!empty($row["barcode"])) {
                                    echo "<b>Barcode</b>: ".$row["barcode"]; }
                                echo "</td><td>";
                                if (isset($row["barcode_stecca"])&&!empty($row["barcode_stecca"])) {
                                    echo "<b>Barcode stecca</b>: ".$row["barcode_stecca"]; }
                                echo "</td></tr>"; }
                        } else { echo "<tr><td colspan='4'>Nessun tabacco trovato</td></tr>"; }
                        echo "</table>";
                    } else {
                        $num_righe = mysqli_num_rows($result);
                        echo "<table><tr><th>Codice AAMS</th><th>Descrizione</th><th></th></tr>";
                        if ($num_righe > 0) {
                            for ($i = 0; $i < $num_righe; $i++) {
                                $row =mysqli_fetch_assoc($result);
                                echo "<tr><td>".$row["aams_code"]."</td><td>".$row["descrizione"]."</td>
                                <td><a href='tabacchi.php?tipo=aams&cerca=".$row["aams_code"]."'>VISUALIZZA</a></td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Nessun tabacco trovato</td></tr>";
                        }
                        echo "</table>";
                    }
                }
            ?>
        </div>
        <!--carica per ultimi-->
        <img class=background_img src="images\background2.jpg">
        <script>
            function cambioTipo() {
                var tipo=document.getElementById("tipo").value;
                if (tipo==="aams") {
                    document.getElementById("cerca").pattern="\\d*";
                } else {
                    document.getElementById("cerca").removeAttribute("pattern");
                }
            }
        </script>
    </body>
</html>