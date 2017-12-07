<?php
   include("php/session.php");
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Tabaccheria Online</title>
		<link rel="shortcut icon" href="images/icon.ico">
		<link rel="stylesheet" href="css/navigation.css">
		<link rel="stylesheet" href="css/gestionale.css">
		<link rel="stylesheet" href="css/base.css">
		<style>
			h2 {
				margin: 20px 0 20px 10px;
				font-size: 30px;
			}
			
			p {
				margin: 50px 0 40px 10px;
			}
		</style>
	</head>

	<body>
		
		<!--NAVIGATION MENU-->
		<?php
			$page_active="supporto";
			include("navigation.php");
		?>
		
		<div class=box>
		
		<h2>Guide</h2>
		
		<p>Guida all'uso: <i>none</i></p>
		
		<h2>Contatta lo sviluppatore</h2>
		
		<p>E-mail: <a href="mailto:nicholasboin@altervista.org">nicholasboin@altervista.org</a></p>
		<p>Telefono: <a href="tel:0425136789">0425 136789</a></p>
		<p>Sede legale:<br/><br/>
			1600 Amphitheatre Parkway<br/>
			Mountain View, CA 94043</p>
		
		
		</div>
		<!--carica per ultimi-->
		<img class=background_img src="images\background2.jpg">
	</body>
</html>