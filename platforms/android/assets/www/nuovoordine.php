<?php
   include("php/session.php");
	date_default_timezone_set('Europe/Rome');
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Nuovo ordine</title>
		<link rel="shortcut icon" href="images/icon.ico">
		<link rel="stylesheet" href="css/navigation.css">
		<link rel="stylesheet" href="css/gestionale.css">
		<link rel="stylesheet" href="css/base.css">
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
			<h1>Creazione nuovo ordine</h1>
			<form action="php/nuovo_ordine.php" method=POST>
				<b>Data di spedizione desiderata</b>: <input type=date name="data" 
				min="<?php echo date('Y-m-d', strtotime(date('Y-m-d') .' +3 day')); ?>" required />
				<input type=submit />
			</form>
			
		</div>
		<!--carica per ultimi-->
		<img class=background_img src="images\background2.jpg">
	</body>
</html>