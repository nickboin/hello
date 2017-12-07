<?php
	include("php/connetti.php");
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Registra Tabaccheria</title>
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
				&nbsp Registra tabaccheria
			</h1>
			<?php if (isset($_GET["error"])&&$_GET["error"]=="yes") echo "<div style='color:red;'><br/><b>ATTENZIONE! IL FORM CONTIENE DEGLI ERRORI!</b></div>"; ?>
			<form action="php/newtabac.php" method=GET>
				<p>
					<table id=dati>
						<tr>
							<td><b>Nome<span style="color:red;">*</span></b></td>
							<td><input class=field type=text name=nome <?php if (isset($_GET["nome"])) { echo "value='".$_GET["nome"]."'"; } ?> required/></td>
						</tr>
						<tr>
							<td><b>Partita IVA<span style="color:red;">*</span></b></td>
							<td><input type=text pattern="[0-9]{11,11}" onkeypress='return ( event.charCode >= 48 && event.charCode <= 57 )'
								maxlength=11 name=piva <?php if (isset($_GET["piva"])) { echo "value='".$_GET["piva"]."'"; } ?> size=15 required/>
							 &nbsp <b>Numero tabaccheria<span style="color:red;">*</span></b> &nbsp 
							<input type=number min=1 name=numero <?php if (isset($_GET["numero"])) { echo "value='".$_GET["numero"]."'"; } ?> size=5 required/>
							</td>
						</tr>
						<tr>
							<td><b>Regione<span style="color:red;">*</span></b></td>
							<td>
								<select class=optionpane name=regione onchange="this.form.submit()">
									<option <?php if (!isset($_GET["regione"])) { echo "selected"; } ?> disabled>Seleziona...</option>
									<?php	//elenco delle regioni
										$sql = "SELECT * FROM Regione";
										$result = mysqli_query($conn, $sql);
										if ($result == false) { echo $result->mysqli_error(); }
										else {
											for ( $i = 0; $i < mysqli_num_rows ( $result ); $i ++){
												$temp_row = mysqli_fetch_assoc ( $result );
												echo '<option value="'.$temp_row["nome"].'"';
												if (isset($_GET["regione"]) && $_GET["regione"]==$temp_row["nome"]) { echo " selected"; } //seleziona se specificato da parametro
												echo ">".$temp_row["nome"]."</option>\n";
											}
										}
									?>
								</select>
								 &nbsp <b>Provincia<span style="color:red;">*</span></b> &nbsp 
								<select class=optionpane name=provincia onchange="this.form.submit()">
									<option <?php if (!isset($_GET["provincia"])) { echo "selected"; } ?> disabled>Seleziona...</option>
									<?php
										$sql = 'SELECT * FROM Provincia WHERE regione="'.$_GET["regione"].'"';
										$result = mysqli_query($conn, $sql);
										if ($result == false) { echo $result->mysqli_error(); }
										else {
											for ( $i = 0; $i < mysqli_num_rows ( $result ); $i ++){
												$temp_row = mysqli_fetch_assoc ( $result );
												echo "<option value='".$temp_row["sigla"]."'";
												if (isset($_GET["provincia"]) && $_GET["provincia"]==$temp_row["sigla"]) { echo " selected"; } //seleziona se specificato da parametro
												echo ">".$temp_row["nome"]."</option>\n";
											}
										}
									?>
								</select>
								 &nbsp <b>Comune<span style="color:red;">*</span></b> &nbsp 
								<select class=optionpane name=comune>
									<option <?php if (!isset($_GET["comune"])) { echo "selected"; } ?> disabled>Seleziona...</option>
									<?php
										$sql = 'SELECT * FROM Comune WHERE provincia="'.$_GET["provincia"].'"';
										$result = mysqli_query($conn, $sql);
										if ($result == false) { echo $result->mysqli_error(); }
										else {
											for ( $i = 0; $i < mysqli_num_rows ( $result ); $i ++){
												$temp_row = mysqli_fetch_assoc ( $result );
												echo '<option value="'.$temp_row["nome"].'"';
												if (isset($_GET["comune"]) && $_GET["comune"]==$temp_row["nome"]) { echo " selected"; } //seleziona se specificato da parametro
												echo ">".$temp_row["nome"]."</option>\n";
											}
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td><b>Località</b></td>
							<td><input class=field type=text name=localita <?php if (isset($_GET["localita"])) { echo "value='".$_GET["localita"]."'"; } ?>/></td>
						</tr>
						<tr>
							<td><b>Indirizzo</b></td>
							<td><input class=field type=text name=indirizzo <?php if (isset($_GET["indirizzo"])) { echo "value='".$_GET["indirizzo"]."'"; } ?>/>
							 &nbsp <b>N. Civico</b> &nbsp 
							<input type=text size=6 maxlength=10 name=n_civico <?php if (isset($_GET["n_civico"])) { echo "value='".$_GET["n_civico"]."'"; } ?>/></td>
						</tr>
						<tr>
							<td><b>Telefono</b></td>
							<td><input type=text <?php if (isset($_GET["telefono"])) { echo "value='".$_GET["telefono"]."'"; } ?> 
							onkeypress='return ( event.charCode >= 48 && event.charCode <= 57 )' size=40 maxlength=16 name='telefono'/>
							 &nbsp <b>Fax</b> &nbsp 
							<input type=text <?php if (isset($_GET["fax"])) { echo "value='".$_GET["fax"]."'"; } ?> 
							onkeypress='return ( event.charCode >= 48 && event.charCode <= 57 )' size=40 maxlength=16 name='fax'/></td>
						</tr>
					</table>
				</p>
				<div class=apply>
					<input type=button class=tasto value="ANNULLA" onclick="window.location.href='home.html';"/>
					<input type=submit class=tasto value="AVANTI"/>
				</div>
			</form>
			<div style="position: absolute; float: left; color: red;"><b>* = campi richiesti</b></div>
		</div>
		<!--carica per ultimi-->
		<img class=background_img src="images\background2.jpg"/>
		
		
	</body>
</html>