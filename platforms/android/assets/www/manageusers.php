<?php
	include("php/adminauth.php");
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Gestione utenti</title>
		<link rel="shortcut icon" href="images/icon.ico">
		<link rel="stylesheet" href="css/navigation.css">
		<link rel="stylesheet" href="css/gestionale.css">
		<link rel="stylesheet" href="css/base.css">
		<link rel="stylesheet" href="css/popup.css">
		<link rel="stylesheet" href="css/tableelenchi.css">
		<style>
			.tabaccheria .dropdown { background-color: #1DA56D; }
			
			table { margin-top: 55px; }
		</style>
	</head>

	<body>
		
		<!--NAVIGATION MENU-->
		<?php
			$page_active="tabaccheria";
			include("navigation.php");
		?>
		
		<?php //POPUP PER UTENTE INSERITO
		if (isset($_GET['user'])&&!empty($_GET['user'])) {
			echo "<div id='inserito' class='overlay'>\n
					<div class='popup'>\n
						<a class='close' href='#'>&times;</a>\n
						<div class='content'>\n
							Utente <b>".$_GET['user']."</b> inserito con successo.\n
						</div>\n
					</div>\n
				</div>\n\n";
				//POPUP PER UTENTE CANCELLATO
				echo "<div id='eliminato' class='overlay'>\n
					<div class='popup'>\n
						<a class='close' href='#'>&times;</a>\n
						<div class='content'>\n
							Utente <b>".$_GET['user']."</b> eliminato con successo.\n
						</div>\n
					</div>\n
				</div>\n\n";} ?>
		
		<div class=box>
			<h1>
				Gestione utenti tabaccheria
			</h1>
			<h2>Tabaccheria: "<?php echo $tabaccheria_nome; ?>" n.<?php echo $tabaccheria_numero.' di '.$tabaccheria_comune.' ('.$tabaccheria_provincia.')'; ?></h2>
			<div class="nuovo_button"><a href="nuovoutente.php">NUOVO UTENTE</a></div>
			<table>
				<tr>
					<th>NOME E COGNOME</th>
					<th>USERNAME</th>
					<th>RUOLO</th>
					<th>AZIONE</th>
				</tr>
				<tr>
					<td><?php echo $logged_user_nome.' '.$user_db_row["cognome"]; ?></td>
					<td><?php echo $logged_user; ?></td>
					<td><img src="images/admin.png" title="Amministratore" height="20px";>&nbsp <?php echo $user_db_row["ruolo"]; ?></td>
					<td><a href="profile.php">GESTISCI</a></td>
				</tr>
				<?php	//genera le righe di tabella con gli utenti necessari
					$sql = "SELECT username, nome, cognome, ruolo FROM Utenti WHERE admin=0 AND tabaccheria=\"".
						$tabaccheria_numero."\" AND comune=\"".$tabaccheria_comune."\" AND provincia=\"".$tabaccheria_provincia."\";";
					$result = mysqli_query($conn, $sql);
					if ($result == false) { echo $result->mysqli_error(); }
					else {
						for ($i = 0; $i < mysqli_num_rows($result); $i++) {
							$row =mysqli_fetch_assoc($result);
							echo "<tr><td>".$row["nome"]." ".$row["cognome"]."</td><td>".$row["username"]."</td><td>".$row["ruolo"].
								"</td><td><a href='modificautente.php?username=".$row["username"]."'>GESTISCI</a> ".
								"<a href='eliminautente.php?username=".$row["username"]."'>ELIMINA</a></td></tr>";
						}
					}
				?>
			</table>
		</div>
		
		<!--carica per ultimi-->
		<img class=background_img src="images\background2.jpg"/>
		
	</body>
</html>