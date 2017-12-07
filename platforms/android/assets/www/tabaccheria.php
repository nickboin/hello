<?php
	include("php/adminauth.php");
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Modifica Tabaccheria</title>
		<link rel="shortcut icon" href="images/icon.ico">
		<link rel="stylesheet" href="css/navigation.css">
		<link rel="stylesheet" href="css/gestionale.css">
		<link rel="stylesheet" href="css/base.css">
		<link rel="stylesheet" href="css/forms.css">
		<link rel="stylesheet" href="css/popup.css">
		<link rel="stylesheet" href="css/tableforms.css">
		<style>
                    input[type=checkbox] {
                      /* Double-sized Checkboxes */
                      -ms-transform: scale(1.5); /* IE */
                      -moz-transform: scale(1.5); /* FF */
                      -webkit-transform: scale(1.5); /* Safari and Chrome */
                      -o-transform: scale(1.5); /* Opera */
                      padding: 10px;
                    }
                    
                    .tabaccheria .dropdown {
                            background-color: #1DA56D;
                    }

                    .optionpane:hover, input[type=number]:hover { background-color: #8C8C8C; }

                    .admin_button {
                            position: absolute;
                            right: 30px;
                            top: 40px;
                    }

                    .admin_button > .tasto {
                            background-color: #19A7FF;
                    }

                    .admin_button > .tasto:hover {
                            background-color: #0284ff;
                            color: #A0E1FF;
                    }
		</style>
	</head>

	<body>
		
		<!--NAVIGATION MENU-->
		<?php
			$page_active="tabaccheria";
			include("navigation.php");
		?>
		
		<!-- POPUP PER TABACCHERIA MODIFICATA -->
		<div id='updated' class='overlay'>
			<div class='popup'>
				<a class='close' href='#'>&times;</a>
				<div class='content'>
					Informazioni aggiornate.
				</div>
			</div>
		</div>
		
		<div class=box>
			<h1>
				&nbsp <img src="images\tabaccheria.png" style="vertical-align: middle; border-radius: 5px;" height="50px">
				&nbsp Modifica tabaccheria
			</h1>
			<div class="admin_button"><a href="manageusers.php" class="tasto" title="Visualizza ed amministra gli utenti registrati di questa tabaccheria">GESTISCI UTENTI</a></div>
			<h2>Tabaccheria: n.<?php echo $tabaccheria_numero.' di '.$tabaccheria_comune.' ('.$tabaccheria_provincia.')'; ?></h2>
			<?php if (isset($_GET["error"])&&$_GET["error"]=="yes") echo "<div style='color:red;'><br/><b>ATTENZIONE! IL FORM CONTIENE DEGLI ERRORI!</b></div>"; ?>
			<form action="php/updatetabac.php" method=GET>
				<table id=dati>
					<tr>
						<td><b>Nome<span style="color:red;">*</span></b></td>
						<td><input class=field type=text name=nome value='<?php echo $tabaccheria_nome; ?>' required/></td>
					</tr>
					<tr>
						<td><b>Partita IVA<span style="color:red;">*</span></b></td>
						<td><input type=text pattern="[0-9]{11,11}" onkeypress='return ( event.charCode >= 48 && event.charCode <= 57 )'
							maxlength=11 name=piva value='<?php echo $tabaccheria_row["piva"]; ?>' required/></td>
					</tr>
					<tr>
						<td><b>Località</b></td>
						<td><input class=field type=text name=localita <?php if (isset($tabaccheria_row["localita"])) { echo "value='".$tabaccheria_row["localita"]."'"; } ?>/></td>
					</tr>
					<tr>
						<td><b>Indirizzo</b></td>
						<td><input class=field type=text name=indirizzo <?php if (isset($tabaccheria_row["indirizzo"])) { echo "value='".$tabaccheria_row["indirizzo"]."'"; } ?>/>
						 &nbsp <b>N. Civico</b> &nbsp 
						<input type=text size=6 maxlength=10 name=n_civico <?php if (isset($tabaccheria_row["n_civico"])) { echo "value='".$tabaccheria_row["n_civico"]."'"; } ?>/></td>
					</tr>
					<tr>
						<td><b>Telefono</b></td>
						<td><input type=text <?php if (isset($tabaccheria_row["tel"])) { echo "value='".$tabaccheria_row["tel"]."'"; } ?> 
						onkeypress='return ( event.charCode >= 48 && event.charCode <= 57 )' size=40 maxlength=16 name='tel'/>
						 &nbsp <b>Fax</b> &nbsp 
						<input type=text <?php if (isset($tabaccheria_row["fax"])) { echo "value='".$tabaccheria_row["fax"]."'"; } ?>
						onkeypress='return ( event.charCode >= 48 && event.charCode <= 57 )' size=40 maxlength=16 name='fax'/></td>
					</tr>
                                        <tr>
						<td colspan='2'><input type=checkbox name='ordine_to_magazzino' value='1' 
                                                    <?php if ($tabaccheria_row["ordine_to_magazzino"]!=0) { echo "checked"; } ?>/> 
                                                    Aggiungi automaticamente gli ordini evasi al magazzino</td>
					</tr>
				</table>
				<div class=apply>
					<input type=button class=tasto value="ANNULLA" onclick="window.location.href='main.php';"/>
					<input type=submit class=tasto value="SALVA"/>
				</div>
			</form>
			<div style="position: absolute; float: left; color: red;"><b>* = campi richiesti</b></div>
		</div>
		<!--carica per ultimi-->
		<img class=background_img src="images\background2.jpg"/>
		
		
	</body>
</html>