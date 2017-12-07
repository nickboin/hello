<?php
include("php/session.php");
$data_30gg=date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." -30 days"));
$data_oggi=date("Y-m-d H:i:s");
$mese_oggi=date("m");
$mese_prec=date("m",strtotime(date("Y-m-d")." -1 month"));
$mesi = array("Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre","Novembre", "Dicembre");
$nome_mese_prec=$mese = $mesi[((int)date("n",strtotime(date("Y-m-d")." -1 month")))-1];
$nome_mese_corr=$mese = $mesi[((int)date("n"))-1];
$query_base_totali = "SELECT SUM(prezzo_unitario*pezzi) FROM Vendita v, Tabacco t WHERE v.aams_code=t.aams_code "
        . "AND tabaccheria = '".$tabaccheria_numero."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."'";
$tot_lordo = round(cifra($conn,$query_base_totali.";"),2);
$tot_lordo_30gg = round(cifra($conn,$query_base_totali." AND data BETWEEN '".$data_30gg."' AND '".$data_oggi."';"),2);
$tot_lordo_mese_oggi = round(cifra($conn,$query_base_totali." AND DATE_FORMAT(data,'%m')='".$mese_oggi."';"),2);
$tot_lordo_mese_prec = round(cifra($conn,$query_base_totali." AND DATE_FORMAT(data,'%m')='".$mese_prec."';"),2);


function cifra($conn,$query) {
    /*$query = "SELECT pezzi FROM Magazzino WHERE aams_code='".$aams."' AND tabaccheria = '".$tabaccheria_numero
                ."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';"*/
    $result=mysqli_query($conn,$query);
    if ($result == false) {
        $_SESSION["dettagli_errore"] = mysqli_error($conn);
        $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
        header("Location: php/error.php");
    } else {
        if (mysqli_num_rows($result)<=0) {
            $_SESSION["dettagli_errore"] = "La query non ha restituito risultati.";
            $_SESSION["titolo_errore"] ="Nessun risultato trovato!";
            header("Location: php/error.php");
        } else {
            return (float)mysqli_fetch_array($result)[0];
        }
    }
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Statistiche - Tabaccheria Online</title>
        <link rel="shortcut icon" href="images/icon.ico">
        <link rel="stylesheet" href="css/navigation.css">
        <link rel="stylesheet" href="css/gestionale.css">
        <link rel="stylesheet" href="css/base.css">
        <style>
            table { line-height: 1.75; }
            
            .nuovo_button {
                margin:20px
            }
            .nuovo_button > a, table a {
                background-color: #63B3FF;
                padding: 5px 10px;
                text-decoration: none;
                font-weight: bold;
                color: white;
            }
            .nuovo_button > a:hover, table a:hover {
                background-color: #0284FF;
                color: #A0E1FF;
            }
            
            .tabacco {
                display:inline-block;
                margin-bottom: 5px;
            }
            
            .barra, .percento, .piu, .meno {box-sizing:border-box}
            .barra {
                float: right;
                display: inline-block;
                width: 300px;
                background-color: #fff;
                margin-right: 25px;
            }
            .percento {
                text-align: right;
                line-height: 30px;
                font-weight: 600;
            }
            .piu { background-color: #4CAF50;} /* Green */
            .meno { background-color: #f44336;} /* Red */
        </style>
    </head>
    <body>
        <!--NAVIGATION MENU-->
        <?php
            $page_active="vendite";
            include("navigation.php");
        ?>
        <div class=box>
            <div class="nuovo_button"><a href="vendite.php">&triangleleft; VENDITE</a></div>
            <table style="width:100%">
                <tr>
                    <td style="width:50%;vertical-align:top">
                        <h1>Statistiche</h1>
                        <b>Tabacchi pi&ugrave; venduti</b><br/>
                        <?php
                        $result=mysqli_query($conn,"SELECT SUM(pezzi) FROM Vendita;");
                        if ($result == false) {
                            $_SESSION["dettagli_errore"] = mysqli_error($conn);
                            $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
                            header("Location: php/error.php");
                        } else {
                            if (mysqli_num_rows($result)<=0) {
                                echo "Non ci sono vendite";
                            }
                            $tot_pezzi=(int)mysqli_fetch_array($result)[0];
                            if ($tot_pezzi>0) {
                                $query = "SELECT v.aams_code, descrizione, SUM(pezzi) AS quantita FROM Vendita v, Tabacco t "
                                    ."WHERE v.aams_code=t.aams_code AND tabaccheria = '".$tabaccheria_numero."' AND provincia = '"
                                    .$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."' GROUP BY v.aams_code "
                                    . "ORDER BY quantita DESC LIMIT 5;";
                                $result=mysqli_query($conn,$query);
                                if ($result == false) {
                                    $_SESSION["dettagli_errore"] = mysqli_error($conn);
                                    $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
                                    header("Location: php/error.php");
                                } else {
                                    $righe = mysqli_num_rows($result);
                                    for ($i=0; $i<$righe; $i++) {
                                        $row = mysqli_fetch_assoc($result);
                                        $percento = round(((((int)$row["quantita"])/$tot_pezzi)*100),2);
                                        echo "<div class='tabacco'>".$row["descrizione"]." (AAMS:".$row["aams_code"].")</div> <div class='barra'>"
                                            ."<div class='percento piu' style='width:".$percento."%'>".round($percento,1)."%</div></div>";
                                    }
                                }
                            } else {
                                echo "Non ci sono vendite";
                            }
                        }
                        ?>
                        <br/><br/>
                        <b>Tabacchi pi&ugrave; venduti negli ultimi 30 giorni</b><br/>
                        <?php
                        $result=mysqli_query($conn,"SELECT SUM(pezzi) FROM Vendita WHERE data BETWEEN '".$data_30gg
                                ."' AND '".$data_oggi."';");
                        if ($result == false) {
                            $_SESSION["dettagli_errore"] = mysqli_error($conn);
                            $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
                            header("Location: php/error.php");
                        } else {
                            if (mysqli_num_rows($result)<=0) {
                                echo "Non ci sono vendite";
                            }
                            $tot_pezzi=(int)mysqli_fetch_array($result)[0];
                            if ($tot_pezzi>0) {
                                $query = "SELECT v.aams_code, descrizione, SUM(pezzi) AS quantita FROM Vendita v, Tabacco t "
                                    ."WHERE v.aams_code=t.aams_code AND tabaccheria = '".$tabaccheria_numero."' AND provincia = '"
                                    .$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."' AND data BETWEEN '"
                                    .$data_30gg."' AND '".$data_oggi."' GROUP BY v.aams_code "."ORDER BY quantita DESC LIMIT 5;";
                                $result=mysqli_query($conn,$query);
                                if ($result == false) {
                                    $_SESSION["dettagli_errore"] = mysqli_error($conn);
                                    $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
                                    header("Location: php/error.php");
                                } else {
                                    $righe = mysqli_num_rows($result);
                                    for ($i=0; $i<$righe; $i++) {
                                        $row = mysqli_fetch_assoc($result);
                                        $percento = round(((((int)$row["quantita"])/$tot_pezzi)*100),2);
                                        echo "<div class='tabacco'>".$row["descrizione"]." (AAMS:".$row["aams_code"].")</div> <div class='barra'>"
                                            ."<div class='percento piu' style='width:".$percento."%'>".round($percento,1)."%</div></div>";
                                    }
                                }
                            } else {
                                echo "Non ci sono vendite";
                            }
                        }
                        ?>
                        <br/><br/>
                        <b>Tabacchi meno venduti</b><br/>
                        <?php
                        $result=mysqli_query($conn,"SELECT SUM(pezzi) FROM Vendita;");
                        if ($result == false) {
                            $_SESSION["dettagli_errore"] = mysqli_error($conn);
                            $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
                            header("Location: php/error.php");
                        } else {
                            if (mysqli_num_rows($result)<=0) {
                                echo "Non ci sono vendite";
                            }
                            $tot_pezzi=(int)mysqli_fetch_array($result)[0];
                            if ($tot_pezzi>0) {
                                $query = "SELECT v.aams_code, descrizione, SUM(pezzi) AS quantita FROM Vendita v, Tabacco t "
                                    ."WHERE v.aams_code=t.aams_code AND tabaccheria = '".$tabaccheria_numero."' AND provincia = '"
                                    .$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."' GROUP BY v.aams_code "
                                    . "ORDER BY quantita LIMIT 5;";
                                $result=mysqli_query($conn,$query);
                                if ($result == false) {
                                    $_SESSION["dettagli_errore"] = mysqli_error($conn);
                                    $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
                                    header("Location: php/error.php");
                                } else {
                                    $righe = mysqli_num_rows($result);
                                    for ($i=0; $i<$righe; $i++) {
                                        $row = mysqli_fetch_assoc($result);
                                        $percento = round(((((int)$row["quantita"])/$tot_pezzi)*100),2);
                                        echo "<div class='tabacco'>".$row["descrizione"]." (AAMS:".$row["aams_code"].")</div> <div class='barra'>"
                                            ."<div class='percento meno' style='width:".$percento."%'>".round($percento,1)."%</div></div>";
                                    }
                                }
                            } else {
                                echo "Non ci sono vendite";
                            }
                        }
                        ?>
                        <br/><br/>
                        <b>Tabacchi meno venduti negli ultimi 30 giorni</b><br/>
                        <?php
                        $result=mysqli_query($conn,"SELECT SUM(pezzi) FROM Vendita WHERE data BETWEEN '".$data_30gg
                                ."' AND '".$data_oggi."';");
                        if ($result == false) {
                            $_SESSION["dettagli_errore"] = mysqli_error($conn);
                            $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
                            header("Location: php/error.php");
                        } else {
                            if (mysqli_num_rows($result)<=0) {
                                echo "Non ci sono vendite";
                            }
                            $tot_pezzi=(int)mysqli_fetch_array($result)[0];
                            if ($tot_pezzi>0) {
                                $query = "SELECT v.aams_code, descrizione, SUM(pezzi) AS quantita FROM Vendita v, Tabacco t "
                                    ."WHERE v.aams_code=t.aams_code AND tabaccheria = '".$tabaccheria_numero."' AND provincia = '"
                                    .$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."' AND data BETWEEN '"
                                    .$data_30gg."' AND '".$data_oggi."' GROUP BY v.aams_code "."ORDER BY quantita LIMIT 5;";
                                $result=mysqli_query($conn,$query);
                                if ($result == false) {
                                    $_SESSION["dettagli_errore"] = mysqli_error($conn);
                                    $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
                                    header("Location: php/error.php");
                                } else {
                                    $righe = mysqli_num_rows($result);
                                    for ($i=0; $i<$righe; $i++) {
                                        $row = mysqli_fetch_assoc($result);
                                        $percento = round(((((int)$row["quantita"])/$tot_pezzi)*100),2);
                                        echo "<div class='tabacco'>".$row["descrizione"]." (AAMS:".$row["aams_code"].")</div> <div class='barra'>"
                                            ."<div class='percento meno' style='width:".$percento."%'>".round($percento,1)."%</div></div>";
                                    }
                                }
                            } else {
                                echo "Non ci sono vendite";
                            }
                        }
                        ?>
                    </td>
                    <td style="width:50%;vertical-align:top">
                        <h1>Contabilit&agrave;</h1>
                        <p>        
                            <b>Incasso lordo mese corrente - <?php echo $nome_mese_corr."</b>: ".$tot_lordo_mese_oggi; ?> &euro;
                            <br/><b>Aggio mese corrente - <?php echo $nome_mese_corr."</b>: ".$tot_lordo_mese_oggi; ?> &euro;
                        </p>
                        <p>
                            <b>Incasso lordo ultimi 30 giorni</b> (<?php echo date("d/m/Y",strtotime($data_30gg));
                                        ?>&rightarrow;<?php echo date("d/m/Y").") : ".$tot_lordo_30gg; ?> &euro;
                            <br/><b>Aggio ultimi 30 giorni</b> (<?php echo date("d/m/Y",strtotime($data_30gg));
                                        ?>&rightarrow;<?php echo date("d/m/Y").") : ".round($tot_lordo_30gg*0.1,2); ?> &euro;
                        </p>
                        <p>
                            <b>Incasso lordo mese precedente - <?php echo $nome_mese_prec."</b>: ".$tot_lordo_mese_prec; ?> &euro;
                            <br/><b>Aggio mese precedente - <?php echo $nome_mese_prec."</b>: ".round($tot_lordo_mese_prec*0.1,2); ?> &euro;
                        </p>
                        <p>
                            <b>Incasso lordo totale</b>: <?php echo $tot_lordo; ?> &euro;
                            <br/><b>Aggio totale</b>: <?php echo round($tot_lordo*0.1,2); ?> &euro;
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <!--carica per ultimi-->
        <img class=background_img src="images\background2.jpg">
    </body>
</html>