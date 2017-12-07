<?php
	session_start();
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Registra Utente Amministratore</title>
		<link rel="shortcut icon" href="images/icon.ico">
		<link rel="stylesheet" href="css/gestionale.css">
		<link rel="stylesheet" href="css/base.css">
		<link rel="stylesheet" href="css/forms.css">
		<link rel="stylesheet" href="css/tableforms.css">
		<style>
			.box { top: 30px; }
		</style>
	</head>

	<body>
		
		
		<div class=box>
			<h1>
				&nbsp <img src="images\tabaccheria.png" style="vertical-align: middle; border-radius: 5px;" height="50px">
				&nbsp Registrazione utente amministratore
			</h1>
			<h2>Tabaccheria: <?php echo '"'.$_SESSION["nome_tabaccheria_reg"].'" n.'.$_SESSION["num_tabaccheria_reg"].' di '.$_SESSION["comune_reg"].' ('.$_SESSION["provincia_reg"].')'; ?></h2>
			<form action="php/newadmin.php" method=POST>
				<p>
					<table id=dati>
						<tr>
							<td><b>Userrname<span style="color:red;">*</span></b></td>
							<td><input class=field type=text name=username <?php if (isset($_POST["username"])) { echo "value='".$_POST["username"]."'"; } ?> required/>
								<?php if(isset($_POST["us_error"])&&$_POST["us_error"]=="yes") echo " &nbsp <span style='color: red;'><b>Username non disponibile!</b></span>"; ?>
							</td>
						</tr>
						<tr>
							<td><b>Nome<span style="color:red;">*</span></b></td>
							<td><input type=text name=nome <?php if (isset($_POST["nome"])) { echo "value='".$_POST["nome"]."'"; } ?> required/>
							 &nbsp <b>Cognome</b> &nbsp 
							<input type=text name=cognome <?php if (isset($_POST["cognome"])) { echo "value='".$_POST["cognome"]."'"; } ?>/>
							</td>
						</tr>
						<tr>
							<td><b>E-mail<span style="color:red;">*</span></b></td>
							<td><input class=field type=email name=email <?php if (isset($_POST["email"])) { echo "value='".$_POST["email"]."'"; } ?> required/></td>
						</tr>
						<tr>	<!-- PASSWORD -->
							<td><b>Password<span style="color:red;">*</span></b></td>
							<td><input type=password name='password1' pattern="(.{8,})" required/>
							 &nbsp <b>Ripeti password<span style="color:red;">*</span></b> &nbsp 
							<input type=password name='password2' pattern="(.{8,})" required/><?php if(isset($_POST["pw_error"])&&$_POST["pw_error"]=="yes")
								echo " &nbsp <span style='color: red;'><b>Le password non coincidono!</b></span>"; ?> &nbsp Lunghezza minima di 8 caratteri.
							</td>
						</tr>
						<tr>
							<td><b>Codice Fiscale</b></td>
							<td><input type=text <?php if (isset($_POST["cf"])) { echo "value='".$_POST["cf"]."'"; } ?> 
							maxlength=16 name='cf' pattern="^[A-Z]{6}[A-Z0-9]{2}[A-Z][A-Z0-9]{2}[A-Z][A-Z0-9]{3}[A-Z]$"/>
							 &nbsp <b>Data di nascita</b> &nbsp 
							<input type=date <?php if (isset($_POST["datanascita"])) { echo "value='".$_POST["datanascita"]."'"; } ?> name='datanascita'/></td>
						</tr>
						<tr>
							<td><b>Percorso immagine</b></td>
							<td><input class=field type=text name=immagine <?php if (isset($_POST["immagine"])) { echo "value='".$_POST["immagine"]."'"; } ?>/></td>
						</tr>
						<tr>
							<td><b>Ruolo</b></td>
							<td>
								<input list="ruolo" name="ruolo" <?php if (isset($_POST["ruolo"])) { echo "value='".$_POST["ruolo"]."'"; } ?>/>
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