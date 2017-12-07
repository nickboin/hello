<?php include("php/session.php"); ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Magazzino - Tabaccheria Online</title>
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
        $page_active="magazzino";
        include("navigation.php");
        ?>
        <div class=box>
            <h1>Magazzino</h1>
            <form action="php/editmagazzino.php" method='POST'>
                Aggiungi al magazzino: 
                <input type=hidden name='action' value='aggiungi'/>
                <input type=number min=1 step=1 name="aams" style="width:30%;" required placeholder="Codice AAMS"/>
                <input type=number min=1 step=1 name="pezzi" style="width:25%;" placeholder="Quantit&agrave;" required title="Numero di pacchetti"/>
                <input type=submit value="Aggiungi"/>
            </form>
            <br/>
            <table>
                <tr><th>Codice AAMS</th><th>Descrizione</th><th>Pacchetti</th><th>Valore lordo</th><th></th></tr>
                <?php
                $sql="SELECT m.aams_code, pezzi, t.descrizione, prezzo_unitario "
                    ."FROM Magazzino m,Tabacco t WHERE tabaccheria = '".$tabaccheria_numero."' AND provincia = '"
                    .$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."' AND m.aams_code = t.aams_code;";
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
                            $aams=$row["aams_code"];
                            if (isset($_GET["modifica"])&&$_GET["modifica"]==$aams) {
                                echo "<tr><td><form action='php/editmagazzino.php' method='POST'><input type=hidden name='aams' "
                                    ."value='".$aams."'/>".$aams."<input type=hidden name='action' value='modifica'/></td><td>"
                                    .$row["descrizione"]."</td><td><input type=number min=1 step=1 name='pezzi' value='".$row["pezzi"]
                                    ."' required id='".$aams."'/></td><td></td><td><input type=submit class='fa' title='Salva' "
                                    ."value='&#xf00c;'/></form></td></tr>";
                            } else {
                                $prezzo=((float)$row["prezzo_unitario"])*((float)$row["pezzi"]);
                                echo "<tr><td>".$aams."</td><td>".$row["descrizione"]."</td><td>".$row["pezzi"]."</td><td>".$prezzo
                                    ." &euro;</td><td><a href='magazzino.php?modifica=".$aams."#".$aams."' class='fa fa-pencil' "
                                    ."style='font-size:18px' title='Modifica'/> </a> <a href='eliminamagazzino.php?aams=".$aams
                                    ."' class='fa fa-times' style='font-size:18px' title='Rimuovi'/> </a></td></tr>";
                            }
                        }
                    } else {
                        echo "<tr><td colspan='5'>Non ci sono tabacchi nel magazzino</td></tr>";
                    }
                }
                ?>
            </table>
        </div>
        <!--carica per ultimi-->
        <img class=background_img src="images\background2.jpg">
    </body>
</html>