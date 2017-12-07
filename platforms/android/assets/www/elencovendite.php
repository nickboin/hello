<?php include("php/session.php"); ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Elenco completo vendite</title>
        <link rel="shortcut icon" href="images/icon.ico">
        <link rel="stylesheet" href="css/navigation.css">
        <link rel="stylesheet" href="css/gestionale.css">
        <link rel="stylesheet" href="css/placeholder.css">
        <link rel='stylesheet' href='css/tableelenchi.css'>
        <link rel="stylesheet" href="css/base.css">
        <link rel="stylesheet" href="css/forms.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <style>
            td { text-align: center; }
        </style>

    </head>

    <body>
        <!--NAVIGATION MENU-->
        <?php
        $page_active="vendite";
        include("navigation.php");
        ?>
        <div class=box>
            <h1>Elenco completo delle vendite</h1>
            <table>
                <tr><th>Data &amp; Ora</th><th>Codice AAMS</th><th>Descrizione</th><th>Pacchetti</th><th>Prezzo totale</th><th></th></tr>
                <?php
                $sql="SELECT v.id, v.aams_code, pezzi, t.descrizione, data, prezzo_unitario AS prezzo FROM Vendita v, Tabacco t "
                    ."WHERE tabaccheria = '".$tabaccheria_numero."' AND provincia = '".$tabaccheria_provincia."' AND comune = '"
                    .$tabaccheria_comune."' AND v.aams_code = t.aams_code ORDER BY data DESC;";
                $result = mysqli_query($conn, $sql);
                if ($result == false) {
                    $_SESSION["dettagli_errore"] = mysqli_error($conn);
                    $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
                    header("Location: php/error.php");
                }
                else {
                    $num_righe = mysqli_num_rows($result);
                    $totale=0;
                    if ($num_righe > 0) {
                        for ($i = 0; $i < $num_righe; $i++) {
                            $row=mysqli_fetch_assoc($result);
                            $aams=$row["aams_code"];
                            $data=date("d/m/Y H:i:s",strtotime($row["data"]));
                            $id=$row["id"];
                            if (isset($_GET["modifica"])&&$_GET["modifica"]==$id) {
                                echo "<tr><td><form action='php/editvendita.php' method='POST'><input type=hidden name='id' "
                                    ."value='".$id."'/>".$data."<input type=hidden name='action' value='modifica'/></td><td>".$aams
                                    ."</td><td>".$row["descrizione"]."</td><td><input type=number min=1 step=1 name='pezzi' value='"
                                    .$row["pezzi"]."' required id='".$id."'/></td><td></td><td><input type=submit class='fa' "
                                    ."title='Salva' value='&#xf00c;'/></form></td></tr>";
                            } else {
                                $prezzo=((float)$row["prezzo"])*((float)$row["pezzi"]);
                                echo "<tr><td>".$data."</td><td>".$aams."</td><td>".$row["descrizione"]."</td><td>".$row["pezzi"]
                                    ."</td><td>".$prezzo." &euro;</td><td><a href='elencovendite.php?modifica=".$id."#".$id
                                    ."' class='fa fa-pencil' style='font-size:18px' title='Modifica'/> </a> <a "
                                    ."href='eliminavendita.php?id=".$id."' class='fa fa-times' style='font-size:18px' "
                                    ."title='Rimuovi'/> </a></td></tr>";
                                $totale+=$prezzo;
                            }
                        }
                    } else {
                        echo "<tr><td colspan='6'>Non ci sono vendite registrate</td></tr>";
                    }
                }
                ?>
            </table>
            <?php
                if($totale!=0) { echo "<p align='right' style='margin-right:3.5%'><b>Totale</b>: ".$totale." &euro;</p>"; }
            ?>
        </div>
        <!--carica per ultimi-->
        <img class=background_img src="images\background2.jpg">
    </body>
</html>