<?php
	include("adminauth.php");
	$user_selected_row;
	$nuova_password;
	if (isset($_POST["username"])) {
		$sql = "SELECT * FROM Utenti WHERE username = '".$_POST["username"]."' AND tabaccheria = '".$tabaccheria_numero
			."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';";
		$result = mysqli_query($conn, $sql);
		if ($result == false) {
			$_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
			$_SESSION["dettagli_errore"] = mysqli_error($conn);
			header("Location: error.php");
		}
		if(mysqli_num_rows($result) != 1) {
			$_SESSION["titolo_errore"] ="Errore individuazione utente nella tabaccheria specificata";
			$_SESSION["dettagli_errore"] ="Parametro username non corretto!";
			header("Location: error.php");
		} else {
			$sql = "DELETE FROM Utenti WHERE username = '".$_POST["username"]."';";
			$result = mysqli_query($conn, $sql);
			if ($result == false) {
				$_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL durante la modifica della password!";
				$_SESSION["dettagli_errore"] = mysqli_error($conn);
				header("Location: error.php");
			} else { 	//eliminato con successo
				header("Location: ../manageusers.php?user=".$_POST["username"]."#eliminato");
			}
		}
	} else {
		$_SESSION["dettagli_errore"] ="Parametro username non corretto!";
		$_SESSION["titolo_errore"] ="Errore individuazione utente";
		header("Location: error.php");
	}
?>