<?php
	include("php/adminauth.php");
	$user_selected_row;
	if (isset($_GET["username"])) {
		$sql = "SELECT * FROM Utenti WHERE username = '".$_GET["username"]."' AND tabaccheria = '".$tabaccheria_numero
			."' AND provincia = '".$tabaccheria_provincia."' AND comune = '".$tabaccheria_comune."';";
		$result = mysqli_query($conn, $sql);
		if ($result == false) {
			$_SESSION["dettagli_errore"] = mysqli_error($conn);
			$_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL!";
			header("Location: php/error.php");
		}
		if(mysqli_num_rows($result) == 1){
			$user_selected_row = mysqli_fetch_array($result);
		} else {
			$_SESSION["dettagli_errore"] ="Parametro username non corretto!";
			$_SESSION["titolo_errore"] ="Errore individuazione utente nella tabaccheria specificata";
			header("Location: php/error.php");
		}
	} else {
		$_SESSION["dettagli_errore"] ="Parametro username non corretto!";
		$_SESSION["titolo_errore"] ="Errore individuazione utente";
		header("Location: php/error.php");
	}
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Modifica Utente</title>
		<link rel="shortcut icon" href="images/icon.ico">
		<link rel="stylesheet" href="css/navigation.css">
		<link rel="stylesheet" href="css/gestionale.css">
		<link rel="stylesheet" href="css/base.css">
		<link rel="stylesheet" href="css/forms.css">
		<link rel="stylesheet" href="css/tableforms.css">
		<style>
			.tabaccheria .dropdown { background-color: #1DA56D; }
		</style>
	</head>

	<body>
		
		<!--NAVIGATION MENU-->
		<?php
			$page_active="tabaccheria";
			include("navigation.php");
		?>
		
		
		<div class=box>
			<h1>Modifica utente</h1>
			<h2>Username: <?php echo $_GET["username"]; ?></h2>
			<form action="php/edituser.php" method=POST>
				<p>
					<table id=dati>
						<tr>
							<td><b>Nome<span style="color:red;">*</span></b></td>
							<td><input type=text name=nome <?php if (isset($user_selected_row["nome"])) { echo "value='".$user_selected_row["nome"]."'"; } ?> required/>
							 &nbsp <b>Cognome</b> &nbsp 
							<input type=text name=cognome <?php if (isset($user_selected_row["cognome"])) { echo "value='".$user_selected_row["cognome"]."'"; } ?>/>
							</td>
						</tr>
						<tr>
							<td><b>E-mail<span style="color:red;">*</span></b></td>
							<td><input class=field type=email name=email <?php if (isset($user_selected_row["email"])) { echo "value='".$user_selected_row["email"]."'"; } ?> required/></td>
						</tr>
						<tr>	<!-- PASSWORD -->
							<td><b>Password<span style="color:red;">*</span></b></td>
							<td><input type=button value="REIMPOSTA PASSWORD"  class="tasto" onclick="window.location.href='resetpw.php?username=<?php echo $_GET["username"];?>';"/>
							</td>
						</tr>
						<tr>
							<td><b>Codice Fiscale</b></td>
							<td><input type=text <?php if (isset($user_selected_row["cf"])) { echo "value='".$user_selected_row["cf"]."'"; } ?> 
							maxlength=16 name='cf' pattern="^[A-Z]{6}[A-Z0-9]{2}[A-Z][A-Z0-9]{2}[A-Z][A-Z0-9]{3}[A-Z]$"/>
							 &nbsp <b>Data di nascita</b> &nbsp 
							<input type=date <?php if (isset($user_selected_row["datanascita"])) { echo "value='".$user_selected_row["datanascita"]."'"; } ?> name='datanascita'/></td>
						</tr>
						<tr>
							<td><b>Percorso immagine</b></td>
							<td><input class=field type=text name=immagine <?php if (isset($user_selected_row["immagine"])) { echo "value='".$user_selected_row["immagine"]."'"; } ?>/></td>
						</tr>
						<tr>
							<td><b>Tabaccheria</b></td>
							<td>
								"<?php echo $tabaccheria_nome; ?>" n.<?php echo $tabaccheria_numero.' di '.$tabaccheria_comune.' ('.$tabaccheria_provincia.')'; ?>
								<span style="margin: 0 20px 0 40px;"><b>Ruolo</b></span>
								<input list="ruolo" name="ruolo" <?php if (isset($user_selected_row["ruolo"])) { echo "value='".$user_selected_row["ruolo"]."'"; } ?>/>
								<datalist id="ruolo">
									<option value="Proprietario"/>
									<option value="Amministratore"/>
									<option value="Segretario"/>
									<option value="Caposala"/>
									<option value="Barista"/>
									<option value="Cameriere"/>
									<option value="Dipendente"/>
								</datalist>
							</td>
						</tr>
					</table>
				</p>
				<div class=apply>
					<input type=button class=tasto value="ANNULLA" onclick="window.location.href='main.php';"/>
					<input type=submit class=tasto value="AVANTI"/>
				</div>
			</form>
			<div style="position: absolute; float: left; color: red;"><b>* = campi richiesti</b></div>
		</div>
		<!--carica per ultimi-->
		<img class=background_img src="images\background2.jpg"/>
		
		
	</body>
</html>
