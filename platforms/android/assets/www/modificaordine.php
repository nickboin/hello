<?php
include("php/session.php");
if (!isset($_GET["num"])||empty($_GET["num"])||!is_numeric($_GET["num"])) {
    $_SESSION["dettagli_errore"] = "Numero ordine di riferimento non corretto";
    $_SESSION["titolo_errore"] = "Errore interno!";
    header("Location: php/error.php");
}
$numero_ordine = $_GET["num"];
$sql = "SELECT data_spedizione FROM ordine WHERE tabaccheria = '".$tabaccheria_numero."' AND provincia = '"
        .$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."' AND numero = '".$numero_ordine."';";
$result = mysqli_query($conn, $sql);
$data_sped;
if ($result == false) {
    $_SESSION["dettagli_errore"] = "Query per reperimento data spedizione.<br/>Dettagli:<br/>"+mysqli_error($conn);
    $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
    header("Location: php/error.php");
}
else {
    $data_sped = mysqli_fetch_row($result)[0];
}
$data_spedizione = date("d/m/Y", strtotime($data_sped));
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nuovo ordine</title>
        <link rel="shortcut icon" href="images/icon.ico">
        <link rel="stylesheet" href="css/navigation.css">
        <link rel="stylesheet" href="css/gestionale.css">
        <link rel="stylesheet" href="css/base.css">
        <link rel="stylesheet" href="css/forms.css">
        <link rel="stylesheet" href="css/tableelenchi.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <style>
            td { text-align: center; }
            div.apply {
                display: inline-block;
                margin-left: 0;
            }
        </style>
    </head>

    <body>
        <!--NAVIGATION MENU-->
        <?php
            $page_active="ordine";
            include("navigation.php");
        ?>

        <div class=box>
            <div style="display:inline-block;float:left;margin-left:20px;"><h2>Ordine numero: <?php echo $numero_ordine; ?></h2></div>
            <div style="display:inline-block;float:right;margin:20px;">Data spedizione prevista: <?php echo $data_spedizione; ?></div>
            <form action="php/prodotto_ordine.php" method=POST id="nuovo_elemento">
                <input type=hidden name="ordine" value="<?php echo $numero_ordine; ?>" />
                <table>
                    <tr><th>Codice AAMS</th><th>Pezzi</th><th>Descrizione</th><th>Totale netto</th><th>Totale lordo</th><th></th></tr>
                        <?php
                        $sql="SELECT o.aams_code, o.pezzi, t.descrizione, prezzo_unitario "
                        ."FROM Ordinato o,Tabacco t WHERE numero_ordine = '".$numero_ordine."' AND tabaccheria = '"
                        .$tabaccheria_numero."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune
                        ."' AND o.aams_code = t.aams_code;";
                        $result = mysqli_query($conn, $sql);
                        if ($result == false) {
                            $_SESSION["dettagli_errore"] = mysqli_error($conn);
                            $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
                            header("Location: php/error.php");
                        }
                        else {
                            $num_righe = mysqli_num_rows($result);
                            if ($num_righe > 0) {
                                for ($i = 0; $i < $num_righe; $i++) {
                                    $row=mysqli_fetch_assoc($result);
                                    $prezzo=((float)$row["pezzi"])*((float)$row["prezzo_unitario"]);
                                    $prezzo_netto=$prezzo-($prezzo*0.1);
                                    if(isset($_POST["modifica"])&&$_POST["modifica"]==$row["aams_code"]) {
                                        echo "<tr><td><input type=number value='".$row["aams_code"]."' disabled /></td><td><input "
                                        ."type=number name='pezzi' step='1' min='1' value='".$row["pezzi"]."' required autofocus /></td>
                                        <td>".$row["descrizione"]."</td><td></td><td></td><td><input type='hidden' name='edited' value='1' />"
                                        ."<input type=hidden name='aams_code' value='".$row["aams_code"]."' /><input type=submit class='fa' "
                                        ."title='Salva' value='&#xf00c;'/></td></tr>";
                                    } else {
                                        echo "<tr><td>".$row["aams_code"]."</td><td>".$row["pezzi"]."</td><td>".$row["descrizione"]."</td><td>"
                                        .$prezzo_netto." &euro;</td><td>".$prezzo." &euro;</td><td><a href='php/prodotto_ordine.php?ordine=".$numero_ordine
                                        ."&aams=".$row["aams_code"]."&act=modifica' class='fa fa-pencil' style='font-size:18px' title='Modifica'> </a> 
                                        <a href='php/prodotto_ordine.php?ordine=".$numero_ordine."&aams=".$row["aams_code"]."&act=elimina' "
                                        ."class='fa fa-times'  title='Cancella' style='font-size:18px'> </a></td></tr>";
                                    }
                                }
                            }
                        }

                        if (!isset($_POST["modifica"])||empty($_POST["modifica"])) {
                            echo "<tr>
                                <td><input type=number name='aams_code' min='1' step='1' required autofocus /></td>
                                <td><input type=number name='pezzi' step='1' min='1' required /></td>
                                <td colspan='4'></td></tr></table>
                                <div align='right' style='margin-right:30px;'><input type=submit class='fa' value='&#xf067;' title='Inserisci'/></div>";
                        }
                        ?>
                    </table>
                </form>
                <?php
                if(!isset($_POST["modifica"])) {
                    echo "<div class=apply><input type=button class=tasto value='AVANTI' onclick='avanti();' /></div>
                            <div class=apply><form action='php/deleteorder.php' method=POST>
                            <input type=hidden name='numero' value='".$numero_ordine."' />
                            <input type=submit class=tasto value='ELIMINA'/>
                            </form></div>"; }
                ?>
        </div>
        <!--carica per ultimi-->
        <img class=background_img src="images\background2.jpg">
        <script>
            function avanti() {
                var form = document.forms['nuovo_elemento'];
                var complete=document.createElement("INPUT");
                // setta attributi
                complete.setAttribute("type","hidden");
                complete.setAttribute("name","completo");
                complete.setAttribute("value","1");
                // appendi al relativo padre
                form.appendChild(complete);
                form.submit();
            }
        </script>
    </body>
</html>