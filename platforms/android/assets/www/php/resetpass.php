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
			//updato password con quella nuova
			$nuova_password = randomString(8);
			$sql = "UPDATE Utenti SET password = '".hash("sha512", $nuova_password)."' WHERE username = '".$_POST["username"]."';";
			$result = mysqli_query($conn, $sql);
			if ($result == false) {
				$_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL durante la modifica della password!";
				$_SESSION["dettagli_errore"] = mysqli_error($conn);
				header("Location: error.php");
			}
		}
	} else {
		$_SESSION["dettagli_errore"] ="Parametro username non corretto!";
		$_SESSION["titolo_errore"] ="Errore individuazione utente";
		header("Location: error.php");
	}
	
	
//genera una stringa alfanumerica con casuale di lunghezza specificata
function randomString ($length) {
	$salt = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ012345678!%&/()=?^*_-+';
	$len = strlen($salt);
	$makepass = '';
	mt_srand(10000000*(double)microtime());
	for ($i = 0; $i < $length; $i++) {
		$makepass .= $salt[mt_rand(0,$len - 1)]; }
	return $makepass;
}
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Resetta password</title>
		<link rel="shortcut icon" href="../images/icon.ico">
		<link rel="stylesheet" href="../css/navigation.css">
		<link rel="stylesheet" href="../css/gestionale.css">
		<link rel="stylesheet" href="../css/base.css">
		<link rel="stylesheet" href="../css/forms.css">
		<style>
			.tabaccheria .dropdown { background-color: #1DA56D; }
		</style>
	</head>

	<body>
		<!--NAVIGATION MENU-->
		<?php
			$php_dir=true;
			$page_active="tabaccheria";
			include("../navigation.php");
		?>
		
		<div class=box>
			<h1>Reset password utente</h1>
			<h2>Password dell'utente "<?php echo $_POST["username"]; ?>" resettata.</h2>
			La sua nuova password è: <b><?php echo $nuova_password; ?></b><br>
			Comunicarla al proprietario dell'account per permetterne il login corretto; sarà possibile modificarla in seguito da parte sua.
			<br/><br/>
			<button onclick="window.location='../manageusers.php';" class="tasto">TORNA INDIETRO</button>
			
			
			<!-- TORNA INDIETRO -->
			
		</div>
		<!--carica per ultimi-->
		<img class=background_img src="..\images\background2.jpg"/>
	</body>
</html>
