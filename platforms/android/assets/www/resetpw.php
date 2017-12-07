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
		if(mysqli_num_rows($result) != 1) {
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
		<title>Resetta password</title>
		<link rel="shortcut icon" href="images/icon.ico">
		<link rel="stylesheet" href="css/navigation.css">
		<link rel="stylesheet" href="css/gestionale.css">
		<link rel="stylesheet" href="css/base.css">
		<link rel="stylesheet" href="css/forms.css">
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
			<h1>Reset password utente</h1>
			<h2>Sei sicuro di voler resettare la password dell'utente "<?php echo $_GET["username"]; ?>"?</h2>
			<form action="php/resetpass.php" method="POST">
				<input type=hidden name="username" value="<?php echo $_GET["username"];?>"/>
				<div class=apply>
					<input type=button class=tasto value="ANNULLA" onclick="window.location.href='modificautente.php?<?php echo $_GET["username"]; ?>';"/>
					<input type=submit class=tasto value="AVANTI"/>
				</div>
			</form>
		</div>
		<!--carica per ultimi-->
		<img class=background_img src="images\background2.jpg"/>
		
	</body>
</html>
