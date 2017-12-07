<?php
   include("php/session.php");
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Ordini</title>
		<link rel="shortcut icon" href="images/icon.ico">
		<link rel="stylesheet" href="css/navigation.css">
		<link rel="stylesheet" href="css/gestionale.css">
		<link rel="stylesheet" href="css/popup.css">
		<link rel="stylesheet" href="css/base.css">
		<link rel="stylesheet" href="css/tableelenchi.css">
		<style>
			td { text-align: center; }
		</style>
	</head>

	<body>
		
		<!--NAVIGATION MENU-->
		<?php
			$page_active="ordine";
			include("navigation.php");
		?>
		
		<?php //popup per ordine cancellato
		if (isset($_GET["eliminato"])&&!empty($_GET["eliminato"])) {
			echo "<div id='eliminato' class='overlay'>
				<div class='popup'>
					<a class='close' href='#'>&times;</a>
					<div class='content'>
						Ordine n.".$_GET["eliminato"]." cancellato.
					</div>
				</div>
			</div>"; } ?>
		
		<div class=box>
			<br/>
			<div class="nuovo_button"><a href="nuovoordine.php">Nuovo ordine</a></div>
			<h3>Ordini in corso</h3>
			<?php
				$sql = "SELECT Ordine.numero AS numero, data_aggiornamento, data_spedizione, SUM(pezzi * prezzo_stecca) AS totale FROM "
                                        ."Ordine,Ordinato,Tabacco WHERE Ordine.tabaccheria = '".$tabaccheria_numero."' AND Ordine.provincia = '"
                                        .$tabaccheria_provincia."' AND Ordine.comune = '".$tabaccheria_comune."' AND Ordine.data_evasione IS NULL AND "
                                        ."Ordine.numero=Ordinato.numero_ordine AND Ordinato.aams_code=Tabacco.aams_code GROUP BY Ordine.numero ORDER BY data_spedizione DESC;";
				$result = mysqli_query($conn, $sql);
				if ($result == false) {
					$_SESSION["dettagli_errore"] = mysqli_error($conn);
					$_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
					header("Location: php/error.php");
				}
				else {
					$num_righe = mysqli_num_rows($result);
					echo "<table><tr><th>Numero</th><th>Aggiornato</th><th>Spedizione</th><th>Totale lordo</th><th>Operazioni</th></tr>";
					if ($num_righe > 0) {
						for ($i = 0; $i < $num_righe && $i < 5; $i++) {
							 $row =mysqli_fetch_assoc($result);
							 echo "<tr><td>".$row["numero"]."</td><td>".date("d/m/Y H:i:s", strtotime($row["data_aggiornamento"]))."</td><td>"
								.date("d/m/Y", strtotime($row["data_spedizione"]))."</td><td>".$row["totale"]
                                                                 ." &euro;</td><td><a href='infoordine.php?num=".$row["numero"]."'>VISUALIZZA</a> 
								<a href='modificaordine.php?num=".$row["numero"]."'>MODIFICA</a> 
								<a href='eliminaordine.php?num=".$row["numero"]."'>ELIMINA</a></td></tr>";
						}
					} else {
						echo "<tr><td colspan='5'>Nessun ordine trovato</td></tr>";
					}
					echo "</table>";
					if ($num_righe > 5) {
						echo "<br/><a style='float:right;' href='elencoordini.php?tipo=aperti'>Vedi tutti</a>";
					}
				}
			?>
			<br/><br/>
			<h3>Ordini evasi</h3>
			<?php
				$sql = "SELECT Ordine.numero AS numero, data_aggiornamento, data_spedizione, data_evasione, SUM(pezzi * prezzo_stecca) AS totale FROM "
                                        ."Ordine,Ordinato,Tabacco WHERE Ordine.tabaccheria = '".$tabaccheria_numero."' AND Ordine.provincia = '"
                                        .$tabaccheria_provincia."' AND Ordine.comune = '".$tabaccheria_comune."' AND Ordine.data_evasione IS NOT NULL AND "
                                        ."Ordine.numero=Ordinato.numero_ordine AND Ordinato.aams_code=Tabacco.aams_code GROUP BY Ordine.numero ORDER BY data_evasione DESC;";
				$result = mysqli_query($conn, $sql);
				if ($result == false) {
					$_SESSION["dettagli_errore"] = mysqli_error($conn);
					$_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
					header("Location: php/error.php");
				}
				else {
					$num_righe = mysqli_num_rows($result);
                                        echo "<table><tr><th>Numero</th><th>Aggiornato</th><th>Spedito</th><th>Evaso</th><th>Prezzo lordo</th><th>Operazioni</th></tr>";
					if ($num_righe > 0) {
						for ($i = 0; $i < $num_righe && $i < 5; $i++) {
							$row =mysqli_fetch_assoc($result);
							echo "<tr><td>".$row["numero"]."</td><td>".date("d/m/Y H:i:s",strtotime($row["data_aggiornamento"]))."</td><td>"
							.date("d/m/Y", strtotime($row["data_spedizione"]))."</td><td>".date("d/m/Y H:i:s", strtotime($row["data_evasione"]))
							."</td><td>".$row["totale"]." &euro;</td><td><a href='infoordine.php?num=".$row["numero"]."'>VISUALIZZA</a></td></tr>";
						}
					} else {
						echo "<tr><td colspan='6'>Nessun ordine trovato</td></tr>";
					}
					echo "</table>";
					if ($num_righe > 5) {
						echo "<br/><a style='float:right;' href='elencoordini.php?tipo=evasi'>Vedi tutti</a>";
					}
				}
			?>
		</div>
		<!--carica per ultimi-->
		<img class=background_img src="images\background2.jpg">
	</body>
</html>