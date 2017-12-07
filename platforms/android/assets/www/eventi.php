<?php
   include("php/session.php");
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Eventi - Tabaccheria Online</title>
        <link rel="shortcut icon" href="images/icon.ico">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- per icone -->
        <link rel="stylesheet" href="css/navigation.css">
        <link rel="stylesheet" href="css/gestionale.css">
        <link rel="stylesheet" href="css/base.css">
        <style>
            th:first-child { text-align: left; }
            td:first-child { text-align: left; }
            td { text-align: center; }
            th:last-child { text-align: right; }
            td:last-child { text-align: right; }
            
            .nuovo_button {
                margin-right: 10px;
                background-color: #63B3FF;
                padding: 5px 10px;
                text-decoration: none;
                font-weight: bold;
                color: white;
            }

            .nuovo_button:hover {
                background-color: #0284FF;
                color: #A0E1FF;
            }
            
            .elenco_eventi { line-height:1.8; }
            .elenco_eventi a { color: black; }
            .elenco_eventi a:visited { color: black; }
            .elenco_eventi a:hover { color: #32D390; }
        </style>
        <script type="text/javascript">
            function spoiler(id) {
                var elemento = document.getElementById(id);
                var display = elemento.style.display;
                var apri = display!=="block";
                if (apri)
                    elemento.style.display = "block";
                else
                    elemento.style.display = "none";
            }
        </script>
    </head>

    <body>
        <!--NAVIGATION MENU-->
        <?php
            $page_active="eventi";
            include("navigation.php");
            $timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : strtotime(date('Y-m-d'));
            $oggi = isset($_GET['timestamp']) ? date('Y-m-d',$_GET['timestamp']) : date('Y-m-d');
            $ieri = strtotime($oggi .' -1 day');
            $domani = strtotime($oggi .' +1 day');
        ?>
        <div class=box>
            <p align="right"><a href="nuovoevento.php<?php if(isset($_GET["timestamp"])) { echo "?timestamp=".$timestamp; } ?>"
                                class="nuovo_button">Nuovo evento</a></p>
            <table style="width:100%;margin:25px 0 40px 0;">
                <tr>
                    <td style="text-align:right;width:25%;font-size:18pt;">
                        <a href="eventi.php?timestamp=<?php echo $ieri; ?>">&ltrif;Precedente</a>
                    </td>
                    <td style="font-size:20pt;">
                        <a onclick="spoiler('vaiadata')" style="cursor:pointer;"><?php echo dataBella((int)$timestamp); ?></a>
                            <form action="php/vaiadata.php" method="GET" id="vaiadata" style="display:none;">
                                <input type="date" name="data" onchange="this.form.submit();" required/> <input type="submit" value="VAI"/>
                            </form>
                    </td>
                    <td style="text-align:left;width:25%;font-size:18pt;">
                        <a href="eventi.php?timestamp=<?php echo $domani; ?>">Seguente&rtrif;</a>
                    </td>
                </tr>
            </table>
            
            <table style="width:100%;">
                <tr>
                    <th style="width:25%"><h2>Eventi del giorno prima</h2></th>
                    <th><h2>Eventi in giornata</h2></th>
                    <th style="width:25%"><h2>Eventi del giorno dopo</h2></th>
                </tr>
                <tr class="elenco_eventi">
                    <td>
                        <?php
                        $result=mysqli_query($conn,"SELECT * FROM Evento WHERE DATE_FORMAT(data,'%Y-%m-%d')='"
                                .date("Y-m-d",$ieri)."' AND tabaccheria='".$tabaccheria_numero."' AND provincia='"
                                .$tabaccheria_provincia."' AND comune='".$tabaccheria_comune."' ORDER BY data DESC;");
                        elencoEventi($result);
                        ?>
                    </td>
                    <td>
                        <?php
                        $result=mysqli_query($conn,"SELECT * FROM Evento WHERE DATE_FORMAT(data,'%Y-%m-%d')='".$oggi
                                ."' AND tabaccheria='".$tabaccheria_numero."' AND provincia='".$tabaccheria_provincia
                                ."' AND comune='".$tabaccheria_comune."' ORDER BY data DESC;");
                        elencoEventi($result);
                        ?>
                    </td>
                    <td>
                        <?php
                        $result=mysqli_query($conn,"SELECT * FROM Evento WHERE DATE_FORMAT(data,'%Y-%m-%d')='"
                                .date("Y-m-d",$domani)."' AND tabaccheria='".$tabaccheria_numero."' AND provincia='"
                                .$tabaccheria_provincia."' AND comune='".$tabaccheria_comune."' ORDER BY data DESC;");
                        elencoEventi($result);
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        <!--carica per ultimi-->
        <img class=background_img src="images\background2.jpg">
    </body>
</html>
<?php
function dataBella ($timestamp) {
    // definisco due array arbitrarie
    $giorni = array("Domenica", "Luned&igrave;", "Marted&igrave;", "Mercoled&igrave;", "Gioved&igrave;", "Venerd&igrave;", "Sabato");
    $mesi = array("Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre","Novembre", "Dicembre");
    $giorno = $giorni[date("w",$timestamp)];
    $giorno_numero = date("j",$timestamp);
    $mese = $mesi[date("n",$timestamp)-1];
    $anno = date("Y",$timestamp);
    return $giorno.", ".$giorno_numero." ".$mese." ".$anno;
}

function elencoEventi($result) {
    if (mysqli_num_rows($result)<=0) {
        echo "Nessun evento!";
    } else {
        for ($i=0; $i<mysqli_num_rows($result); $i++) {
            $row=mysqli_fetch_assoc($result);
            $id=$row["id"];
            $completa="";
            if ($row["completato"]==0)
                $completa=" &nbsp<a href='php/toggleevento.php?id=".$id."' title='Completato' class='fa fa-check-square-o'></a>";
            $ora=date("H:i",strtotime($row["data"]));
            echo "<a href='modificaevento.php?id=".$id."' class='fa fa-pencil-square-o' title='Modifica'></a> &nbsp<a "
                ."href='eliminaevento.php?id=".$id."' class='fa fa-trash-o' title='Cancella'></a>".$completa." &nbsp ";
            if ($row["completato"]!=0)
                echo "<s title='Evento completato'>";
            echo $ora.": <b><a href='evento.php?id=".$id."'>".$row["titolo"]."</a></b>";
            if ($row["completato"]!=0)
                echo "</s>";
            echo "<br/>";
        }
    }
}
?>