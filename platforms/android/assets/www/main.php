<?php
    include("php/session.php");
    date_default_timezone_set('Europe/Rome');
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Tabaccheria Online</title>
        <link rel="shortcut icon" href="images/icon.ico">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- per icone -->
        <link rel="stylesheet" href="css/navigation.css">
        <link rel="stylesheet" href="css/gestionale.css">
        <link rel="stylesheet" href="css/base.css">
        <style>
            div.tile {
                position:relative;
                display:inline-block;
                width: 100%;
                height: 100%;
                border: double 3px gray;
                border-radius: 10px;
                background-color: white;
            }
            
            div.tile h2 { margin-left: 2.5%; }

            div.tile a.more {
                position: relative;
                bottom: 10px;
                right: 10px;
                z-index: 20;
                font-weight: bold;
                border: solid 1px #32D390;
                padding: 3px 5px;
                background-color: white;
                color: #32D390;
                border-radius: 3px;
                transition: ease 0.3s;
                -o-transition: ease 0.3s;
                -moz-transition: ease 0.3s;
                -webkit-transition: ease 0.3s;
            }

            div.tile a.more:hover {
                background-color: #32D390;
                color: white;
            }
            
            td { padding: 10px; }
            
            table.dati {
                border: solid 1px #0284FF;
                margin-top: 10px;
                border-collapse: collapse;
                width: 95%;
                margin-left: 2.5%;
            }
            table.dati td {
                text-align: center;
                padding: 8px;
            }
            table.dati th { 
                padding: 8px;
                background-color: #0284FF;
                color: white;
            }
            table.dati th, table.dati td:last-child { text-align: center; }
            table.dati tr:nth-child(even) { background-color: #f2f2f2 }
            table.dati tr:nth-child(odd) { background-color: white }
            table.dati tr:hover { background-color: #A5E1FF }
            
            .elenco_eventi {
                line-height:1.8;
                margin-left: 2.5%;
            }
            .elenco_eventi a { color: black; }
            .elenco_eventi a:visited { color: black; }
            .elenco_eventi a:hover { color: #32D390; }
        </style>
    </head>

    <body>
        <!--NAVIGATION MENU-->
        <?php
            $page_active="main";
            include("navigation.php");
        ?>

        <div class=box>
            <div style="margin-bottom:5px;display:inline-block;">Benvenuto <?php echo $logged_user_nome; ?></div>
            <div style="margin-bottom:5px;display:inline-block;float:right;">Oggi &egrave <?php echo dataoggi(); ?></div>
            <center>
                <table id="home" style="width:100%;height:100%">
                    <tr style="height:50%">
                        <td style="width:50%">
                            <div id="ordini" class=tile>
                                <h2>Ordini</h2>
                                <?php
                                    $sql = "SELECT numero, data_spedizione FROM Ordine WHERE tabaccheria = '".$tabaccheria_numero."' AND provincia = '"
                                            .$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."' ORDER BY data_spedizione DESC LIMIT 5;";
                                    $result = mysqli_query($conn, $sql);
                                    if ($result == false) {
                                        $_SESSION["dettagli_errore"] = mysqli_error($conn);
                                        $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
                                        header("Location: php/error.php");
                                    }
                                    else {
                                        $num_righe = mysqli_num_rows($result);
                                        echo "<table class='dati'><tr><th>Numero</th><th>Spedizione</th></tr>";
                                        if ($num_righe > 0) {
                                            for ($i = 0; $i < $num_righe && $i < 5; $i++) {
                                                $row =mysqli_fetch_assoc($result);
                                                echo "<tr><td>".$row["numero"]."</td><td>".date("d/m/Y", strtotime($row["data_spedizione"]))."</td></tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='2'>Nessun ordine trovato</td></tr>";
                                        }
                                        echo "</table>";
                                    }
                                ?>
                                <br/>
                                <p align="right"><a href="ordine.php" class="more">Vedi tutto..</a></p>
                            </div>
                        </td>
                        <td style="width:50%">
                            <div id="eventi" class=tile>
                                <h2>Eventi di oggi</h2>
                                <div class="elenco_eventi">
                                    <?php
                                    $result=mysqli_query($conn,"SELECT id,data,titolo,completato FROM Evento WHERE DATE_FORMAT(data,'%Y-%m-%d')='"
                                            .date("Y-m-d")."' AND tabaccheria='".$tabaccheria_numero."' AND provincia='"
                                            .$tabaccheria_provincia."' AND comune='".$tabaccheria_comune."' ORDER BY data DESC;");
                                    if (mysqli_num_rows($result)<=0) {
                                        echo "Nessun evento!";
                                    } else {
                                        for ($i=0; $i<mysqli_num_rows($result) && $i < 6; $i++) {
                                            $row=mysqli_fetch_assoc($result);
                                            $id=$row["id"];
                                            $ora=date("H:i",strtotime($row["data"]));
                                            echo "<a href='modificaevento.php?id=".$id."' class='fa fa-pencil-square-o' title='Modifica'></a> &nbsp ";
                                            if ($row["completato"]!=0)
                                                echo "<s title='Evento completato'>";
                                            echo $ora.": <b><a href='evento.php?id=".$id."'>".$row["titolo"]."</a></b>";
                                            if ($row["completato"]!=0)
                                                echo "</s>";
                                            echo "<br/>";
                                        }
                                    }
                                    ?>
                                </div>
                                <br/>
                                <p align="right"><a href="eventi.php" class="more">Vedi tutto..</a></p>
                            </div>
                        </td>
                    </tr>
                    <tr style="height:50%">
                        <td style="width:50%">
                            <div id="tabacchi" class=tile>
                                <h2>Tabacchi</h2>
                                <?php
                                    $result = mysqli_query($conn, "SELECT aams_code, descrizione FROM tabacco LIMIT 5;");
                                    if ($result == false) {
                                        $_SESSION["dettagli_errore"] = mysqli_error($conn);
                                        $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL tabacchi!";
                                        header("Location: php/error.php");
                                    } else {
                                        $num_righe = mysqli_num_rows($result);
                                        echo "<table class='dati'><tr><th>Codice AAMS</th><th>Descrizione</th></tr>";
                                        if ($num_righe > 0) {
                                            for ($i = 0; $i < $num_righe && $i < 5; $i++) {
                                                $row =mysqli_fetch_assoc($result);
                                                echo "<tr><td>".$row["aams_code"]."</td><td>".$row["descrizione"]."</td></tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='2'>Nessun tabacco trovato</td></tr>";
                                        }
                                        echo "</table>";
                                    }
                                ?>
                                <br/>
                                <p align="right"><a href="tabacchi.php" class="more">Vedi tutto..</a></p>
                            </div>
                        </td>
                        <td style="width:50%">
                            <div id="tabacchi" class=tile>
                                <h2>Vendite</h2>
                                <?php
                                    $sql="SELECT pezzi, t.descrizione, data, prezzo_unitario AS prezzo FROM Vendita v, Tabacco t "
                                        ."WHERE tabaccheria = '".$tabaccheria_numero."' AND provincia = '".$tabaccheria_provincia
                                        ."' AND comune = '".$tabaccheria_comune."' AND v.aams_code = t.aams_code AND data BETWEEN '"
                                        .date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." -7 days"))."' AND '"
                                        .date("Y-m-d H:i:s")."' ORDER BY data DESC LIMIT 5;";
                                    $result = mysqli_query($conn, $sql);
                                    if ($result == false) {
                                        $_SESSION["dettagli_errore"] = mysqli_error($conn);
                                        $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
                                        header("Location: php/error.php");
                                    } else {
                                        $num_righe = mysqli_num_rows($result);
                                        echo "<table class='dati'><tr><th>Data &amp; Ora</th><th>Descrizione</th><th>Prezzo totale</th></tr>";
                                        if ($num_righe > 0) {
                                            for ($i = 0; $i < $num_righe && $i < 5; $i++) {
                                                $row=mysqli_fetch_assoc($result);
                                                $data=date("d/m/Y H:i:s",strtotime($row["data"]));
                                                $prezzo=((float)$row["prezzo"])*((float)$row["pezzi"]);
                                                echo "<tr><td>".$data."</td><td>".$row["descrizione"]."</td>"
                                                    ."<td>".$prezzo." &euro;</td></tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='3'>Non ci sono vendite registrate</td></tr>";
                                        }
                                        echo "</table>";
                                    }
                                ?>
                                <br/>
                                <p align="right"><a href="vendite.php" class="more">Vedi tutto..</a></p>
                            </div>
                        </td>
                    </tr>
                </table>
            </center>
        </div>
        <!--carica per ultimi-->
        <img class=background_img src="images\background2.jpg">
    </body>
</html>
<?php
function dataoggi () {
    // definisco due array arbitrarie
    $giorni = array("Domenica", "Luned&igrave;", "Marted&igrave;", "Mercoled&igrave;", "Gioved&igrave;", "Venerd&igrave;", "Sabato");
    $mesi = array("Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre","Novembre", "Dicembre");
    $giorno = $giorni[date("w")];
    $giorno_numero = date("j");
    $mese = $mesi[date("n")-1];
    $anno = date("Y");
    return $giorno.", ".$giorno_numero." ".$mese." ".$anno;
}
?>