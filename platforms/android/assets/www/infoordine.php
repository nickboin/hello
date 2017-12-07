<?php
   include("php/session.php");
	if (!isset($_GET["num"])||empty($_GET["num"])||!is_numeric($_GET["num"])) {
		$_SESSION["dettagli_errore"] = "Numero ordine di riferimento non corretto";
		$_SESSION["titolo_errore"] = "Errore interno!";
		header("Location: php/error.php");
	}
	$numero_ordine = $_GET["num"];
	$sql = "SELECT data_spedizione, data_creazione, data_aggiornamento, data_evasione FROM ordine WHERE tabaccheria = '".$tabaccheria_numero
		."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."' AND numero = '".$numero_ordine."';";
	$result = mysqli_query($conn, $sql);
	$data_evas_america;
	$data_spedizione;
	$data_aggiornamento;
	$data_creazione;
	if ($result == false) {
		$_SESSION["dettagli_errore"] = "Query per reperimento data spedizione.<br/>Dettagli:<br/>"+mysqli_error($conn);
		$_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
		header("Location: php/error.php");
	}
	else {
		$riga = mysqli_fetch_array($result);
		$data_spedizione = date("d/m/Y", strtotime($riga["data_spedizione"]));
		$data_aggiornamento = date("d/m/Y H:i:s", strtotime($riga["data_aggiornamento"]));
		$data_creazione = date("d/m/Y H:i:s", strtotime($riga["data_creazione"]));
		$data_evas_america = $riga["data_evasione"];
	}
	$data_evasione;
	if ($data_evas_america==null||$data_evas_america==false||empty($data_evas_america)) {
		$data_evasione = null;
	} else {
		$data_evasione = date("d/m/Y H:i:s", strtotime($data_evas_america));
	}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php if (isset($_GET["act"])&&$_GET["act"]=="rivedi") { echo "Rivedi ordine"; } else { echo "Info ordine"; } ?></title>
		<link rel="shortcut icon" href="images/icon.ico">
		<link rel="stylesheet" href="css/navigation.css">
		<link rel="stylesheet" href="css/gestionale.css">
		<link rel="stylesheet" href="css/base.css">
		<link rel="stylesheet" href="css/forms.css">
		<link rel="stylesheet" href="css/popup.css">
		<link rel="stylesheet" href="css/tableelenchi.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<style>
			td { text-align: center; }
			<?php if (!isset($_GET["act"])||$_GET["act"]!="rivedi") {
					echo "table { margin-top: 110px; }"; } ?>
		</style>
	</head>

	<body>
		<!--NAVIGATION MENU-->
		<?php
			$page_active="ordine";
			include("navigation.php");
		?>
		
		<!--popup per ordine appena inserito-->
		<div id='effettuato' class='overlay'>
			<div class='popup'>
				<a class='close' href='#'>&times;</a>
				<div class='content'>
					Ordine effettuato.
				</div>
			</div>
		</div>
		
		<div class=box>
			<div style="display:inline-block;float:left;margin-left:20px;"><h1>Ordine numero: <?php echo $numero_ordine; ?></h1></div>
			<div style="display:inline-block;float:right;margin:20px 20px 0 0;">Data spedizione prevista: <b><?php echo $data_spedizione; ?></b>
				<?php
					if (!isset($_GET["act"])||$_GET["act"]!="rivedi") {
						echo "<br/>Creato: ".$data_creazione."<br/>Aggiornato: ".$data_aggiornamento; }
					if ($data_evasione!=null&&$data_evasione!=false&&!empty($data_evasione)) {
						echo "<br/>Evaso: ".$data_evasione; }
				?>
			</div>
			<table>
				<tr><th>Codice AAMS</th><th>Pezzi</th><th>Descrizione</th><th>Totale netto</th><th>Totale lordo</th></tr>
				<?php
					$sql="SELECT o.aams_code, o.pezzi, t.descrizione, prezzo_unitario "
                                            ."FROM Ordinato o,Tabacco t WHERE numero_ordine = '".$numero_ordine."' AND tabaccheria='"
                                            .$tabaccheria_numero."' AND provincia = '".$tabaccheria_provincia."' AND comune = '"
                                            .$tabaccheria_comune."' AND o.aams_code = t.aams_code;";
					$result = mysqli_query($conn, $sql);
					if ($result == false) {
						$_SESSION["dettagli_errore"] = mysqli_error($conn);
						$_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
						header("Location: php/error.php");
					}
					else {
						$num_righe = mysqli_num_rows($result);
                                                $tot_netto=0;
                                                $tot_lordo=0;
						for ($i = 0; $i < $num_righe; $i++) {
							$row=mysqli_fetch_assoc($result);
                                                        $prezzo=((float)$row["prezzo_unitario"])*((float)$row["pezzi"]);
                                                        $tot_lordo+=(float)$prezzo;
                                                        $prezzo_netto=$prezzo-($prezzo*0.1);
                                                        $tot_netto+=(float)$prezzo_netto;
							echo "<tr><td>".$row["aams_code"]."</td><td>".$row["pezzi"]."</td><td>".$row["descrizione"]
                                                            ."</td><td>".$prezzo_netto." &euro;</td><td>".$prezzo." &euro;</td></tr>";
						}
                                                $aggio=$tot_lordo-$tot_netto;
					}
				?>
			</table>
			<?php
                        echo "<p align='right' style='font-size:18px;margin-right:40px;line-height:1.8;'><b>Totale netto</b>: "
                                .$tot_netto." &euro;<br><b>Aggio</b>: ".$aggio." &euro;<br><b>Totale lordo</b>: ".$tot_lordo." &euro;</p>";
			if (isset($_GET["act"])&&$_GET["act"]=="rivedi") { echo "<div class=apply>
				<input type=button class=tasto value='RIVEDI' onclick=\"window.location.href='modificaordine.php?num=".$numero_ordine."';\" />
				<input type=button class=tasto value='INVIA' onclick=\"window.location.href='infoordine.php?num=".$numero_ordine."#effettuato';\" />
				</div>"; } else {
				echo "<br/><a href='ordine.php'>Torna agli ordini</a>"; }?>
		</div>
		<!--carica per ultimi-->
		<img class=background_img src="images\background2.jpg">
		
	</body>
</html>