<?php
	session_start();
	//nel caso estremo che l'errore non sia settato e venga chiamata la pagina (?????????)
	if(!isset($_SESSION["titolo_errore"])||$_SESSION["titolo_errore"]===0)
		header("Location: ../main.php");
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Errore!</title>
		<link rel="shortcut icon" href="../images/icon.ico">
		<link rel="stylesheet" href="../css/base.css">
        <link rel="stylesheet" href="../css/gestionale.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- per iconcina freccia -->
	</head>

	<body>
        <div class=box style="top: 30px;">
            <h1><a href="" onclick="window.history.back();" class="fa">&#xf060;</a> &nbsp <span style="color:red">ERRORE</span></h1>
            <h2><?php echo $_SESSION["titolo_errore"]; ?></h2>
            <p>Ulteriori dettagli:<br><?php echo $_SESSION["dettagli_errore"]; ?></p>
		</div>
		<!--carica per ultimi-->
		<img class=background_img src="..\images\background2.jpg"/>
	</body>
</html>
<?php	//svuota la session per l'errore
	$_SESSION["titolo_errore"] = 0;
	$_SESSION["dettagli_errore"] = 0;
?>