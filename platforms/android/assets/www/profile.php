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
		<link rel="stylesheet" href="css/modal.css">
		<link rel="stylesheet" href="css/forms.css">
		<link rel="stylesheet" href="css/tableforms.css">
		<link rel="stylesheet" href="css/popup.css">
		<style>
			.user .dropdown {
				background-color: #1DA56D;
			}
			
			img.userimage {
				margin-top: 15px;
				margin-left: 15px;
				border: solid black 1px;
				border-radius: 8px;
				height: 150px;
				width: 150px;
				vertical-align: middle;
				cursor: pointer;
			}
			
			.tooltipbase {
				position: relative;
				display: inline-block;
			}
			
			.name {
				margin-left: 30px;
				position: relative;
				display: inline-block;
			}
			
			.username {
				font-family: Arial, sans-serif;
				font-size: 14px;
				margin-left: 20px;
			}
			
			.name .tooltip {
				visibility: hidden;
				width: 80px;
				background-color: #24B67A;
				color: white;
				font-size: 14px;
				font-weight: normal;
				font-family: 'Roboto', Arial, sans-serif;
				text-align: center;
				padding: 5px 0;
				position: absolute;
				z-index: 1;
				bottom: 100%;
				left: 50%;
				margin-left: -60px;
				cursor: pointer;
				
				/* Fade in tooltip - takes 1 second to go from 0% to 100% opac: */
				opacity: 0;
				-webkit-transition: opacity 750ms;
				-moz-transition: opacity 750ms;
				-o-transition: opacity 750ms;
				transition: opacity 750ms;
				transition-delay: 0.3s;
			}
			
			.tooltipbase .tooltip {
				visibility: hidden;
				width: 80px;
				background-color: #24B67A;
				color: white;
				font-size: 14px;
				font-weight: normal;
				font-family: 'Roboto', Arial, sans-serif;
				text-align: center;
				padding: 5px 0;
				position: absolute;
				z-index: 1;
				bottom: 160px;
				left: 50%;
				margin-left: -35px;
				cursor: pointer;
				
				/* Fade in tooltip*/
				opacity: 0;
				-webkit-transition: opacity 750ms;
				-moz-transition: opacity 750ms;
				-o-transition: opacity 750ms;
				transition: opacity 750ms;
				transition-delay: 0.3s;
			}
			
			.name .tooltip a:hover, .tooltipbase .tooltip a:hover {
				color: white;
			}
			
			.name:hover .tooltip, .tooltipbase:hover .tooltip {
				visibility: visible;
				opacity: 1;
			}
			
			input.email {
				min-width: 350px;
				}
			
			a.tasto:hover {
				color: white;
			}
			
			input.nome {
				background: transparent;
				font-family: 'Century Gothic', 'Roboto', Arial, sans-serif;
				font-size: 35px;
				font-weight: bold;
				border: hidden;
				color: #757575;
			}
			
			input.nome[disabled] {
				color: black;
			}
		</style>
	</head>

	<body>
		
		<!--NAVIGATION MENU-->
		<?php
			$page_active="profile";
			include("navigation.php");
		?>
		
		<div class=box>
			<!-- POPUP PER PASSWORD MODIFICATA -->
			<div id='pw' class='overlay'>
				<div class='popup'>
					<a class='close' href='#'>&times;</a>
					<div class='content'>
						Password modificata.
					</div>
				</div>
			</div>
			
			<!-- POPUP PER PROFILO MODIFICATO -->
			<div id='updated' class='overlay'>
				<div class='popup'>
					<a class='close' href='#'>&times;</a>
					<div class='content'>
						Informazioni aggiornate.
					</div>
				</div>
			</div>
		
			<form action="php/editprofile.php" method=POST>
				
				<span class=tooltipbase>
					<img src="images\user.png" class=userimage id=userimage>
					<span class=tooltip>
						<a onclick="">Modifica</a>
					</span>
				</span>
				<!-- The Modal -->
				<div id="modal" class="modal">
					<!-- The Close Button -->
					<span class="close" onclick="document.getElementById('modal').style.display='none'">&times;</span>
					<!-- Modal Content (The Image) -->
					<img class="modal-content" id="immagine">
					<!-- Modal Caption (Image Text) -->
					<div id="caption"></div>
				</div>
			
				<span id=name class=name>
					<input type=text id=nome name=nome class=nome value='<?php
						echo $user_db_row["nome"]." ".$user_db_row["cognome"]; ?>' maxlenght=60 disabled>
					<span class=tooltip>
						<a onclick="document.getElementById('nome').disabled=false;">Modifica</a>
					</span>
				</span>
				<span id=username class=username>(
					<?php
					echo $logged_user;
					?>
					)</span>
				
				<p>
					<table id=dati>
						<tr>
							<td><b>Tabaccheria</b></td>
							<td><span style="margin-left:10px;">
								<?php echo $tabaccheria_nome; ?> &nbsp &nbsp (P.IVA <?php echo $tabaccheria_row["piva"]; ?>)
							</span></td>
						</tr>
						
						<tr>
							<td><b>Ruolo</b></td>
							<td><span style="margin-left:10px;">
							<?php
							echo $user_db_row["ruolo"];
							?>
							<span/></td>
						</tr>
						<tr>
							<td><b>E-mail</b></td>
							<td><input class=email type=email id=email name="email" required value='
							<?php
							echo $user_db_row["email"];
							?>
							'/></td>
						</tr>
						<tr>
							<td><b>Password</b></td>
							<td>
								<a href="editpw.php" class=tasto>MODIFICA PASSWORD</a>
							</td>
						</tr>
						
						<tr>
							<td><b>Codice Fiscale</b></td>
							<td><span style="margin-left:10px;">
							<?php
							echo $user_db_row["cf"];
							?>
							<span/></td>
						</tr>
						<tr>
							<td><b>Data di nascita</b></td>
							<td><input type=date name="datanascita" value='<?php echo $user_db_row["datanascita"]; ?>'/></td>
						</tr>
					</table>
				</p>
				<div class=apply>
					<input type=button class=tasto value="ANNULLA" onclick="window.location.href='profile.php';"/>
					<input type=submit class=tasto value="SALVA"/>
				</div>
			</form>
		
		</div>
		<!--carica per ultimi-->
		<img class=background_img src="images\background2.jpg">
		
		<script>
			// Get the modal
			var modal = document.getElementById('modal');
			// Get the image and insert it inside the modal - use its "alt" text as a caption
			var img = document.getElementById('userimage');
			var modalImg = document.getElementById("immagine");
			var captionText = document.getElementById("caption");
			img.onclick = function() {
				modal.style.display = "block";
				modalImg.src = this.src;
				captionText.innerHTML = this.alt;
			};
			
			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];
			
			// When the user clicks on <span> (x), close the modal
			span.onclick = function() { 
			  modal.style.display = "none";
			};
		</script>
		
		
	</body>
</html>