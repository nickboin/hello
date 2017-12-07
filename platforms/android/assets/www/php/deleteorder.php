<?php
	include("session.php");
	if (isset($_POST["numero"])) {
		$sql = "SELECT * FROM Ordine WHERE numero = '".$_POST["numero"]."' AND tabaccheria = '".$tabaccheria_numero
			."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';";
		$result = mysqli_query($conn, $sql);
		if ($result == false) {
			$_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
			$_SESSION["dettagli_errore"] = mysqli_error($conn);
			header("Location: error.php");
		}
		if(mysqli_num_rows($result) != 1) {
			$_SESSION["titolo_errore"] ="Errore individuazione ordine nella tabaccheria specificata";
			$_SESSION["dettagli_errore"] ="Parametro numero non corretto!";
			header("Location: error.php");
		} else {
			$data_spedizione;
			$sql = "SELECT data_spedizione FROM ordine WHERE tabaccheria = '".$tabaccheria_numero."' AND provincia = '"
				.$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."' AND numero = '".$_POST["numero"]."';";
			$result = mysqli_query($conn, $sql);
			if ($result == false) {
				$_SESSION["dettagli_errore"] = "Query per reperimento data spedizione.<br/>Dettagli:<br/>"+mysqli_error($conn);
				$_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
				header("Location: error.php");
			}
			else { $data_spedizione = mysqli_fetch_row($result)[0]; }
			if($data_spedizione>date("Y-m-d")) {
				$sql = "DELETE FROM Ordinato WHERE numero_ordine = '".$_POST["numero"]."' AND tabaccheria = '".$tabaccheria_numero
				."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';";
				$result = mysqli_query($conn, $sql);
				if ($result == false) {
					$_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL durante la cancellazione elementi ordine!";
					$_SESSION["dettagli_errore"] = mysqli_error($conn);
					header("Location: error.php");
				} else { 	//eliminati elementi con successo
					$sql = "DELETE FROM Ordine WHERE numero = '".$_POST["numero"]."' AND tabaccheria = '".$tabaccheria_numero
				."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';";
					$result = mysqli_query($conn, $sql);
					if ($result == false) {
						$_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL durante la cancellazione dell'ordine!";
						$_SESSION["dettagli_errore"] = mysqli_error($conn);
						header("Location: error.php");
					} else { 	//eliminato ordine con successo
						header("Location: ../ordine.php?eliminato=".$_POST["numero"]."#eliminato");
					}
				}
			} else {
				$_SESSION["dettagli_errore"] ="E' troppo tardi per annullare l'ordine!";
				$_SESSION["titolo_errore"] ="Impossibile cancellare!";
				header("Location: error.php");
			}
		}
	} else {
		$_SESSION["dettagli_errore"] ="Parametro ordine non corretto!";
		$_SESSION["titolo_errore"] ="Errore individuazione ordine";
		header("Location: error.php");
	}
?>