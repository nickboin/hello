<?php
	include("php/session.php");
	if (!isset($_GET["num"])||empty($_GET["num"])||!is_numeric($_GET["num"])) {
		$_SESSION["dettagli_errore"] = "Numero ordine di riferimento non corretto";
		$_SESSION["titolo_errore"] = "Errore interno!";
		header("Location: php/error.php");
	}
	$numero_ordine = $_GET["num"];
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Eliminazione ordine</title>
		<link rel="shortcut icon" href="images/icon.ico">
		<link rel="stylesheet" href="css/navigation.css">
		<link rel="stylesheet" href="css/gestionale.css">
		<link rel="stylesheet" href="css/base.css">
		<link rel="stylesheet" href="css/forms.css">
		<style>
			
		</style>
	</head>

	<body>
		<!--NAVIGATION MENU-->
		<?php
			$page_active="ordine";
			include("navigation.php");
		?>
		
		<div class=box>
			<h1>Eliminazione ordine</h1>
			<h2>Sei sicuro di voler eliminare l'ordine numero "<?php echo $numero_ordine; ?>"?</h2>
			<form action="php/deleteorder.php" method="POST">
				<input type=hidden name="numero" value="<?php echo $numero_ordine; ?>"/>
				<div class=apply>
					<input type=button class=tasto value="ANNULLA" onclick="window.location.href='ordine.php';"/>
					<input type=submit class=tasto value="AVANTI"/>
				</div>
			</form>
		</div>
		<!--carica per ultimi-->
		<img class=background_img src="images\background2.jpg"/>
		
	</body>
</html>
