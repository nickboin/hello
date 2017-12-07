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
		<style>
			h1 {
				margin: 20px;
			}
			
			input[type=password] {
				min-width: 400px;
			}
			
			div.apply {
				bottom: 20px;
				right: 25px;
				position: absolute;
			}
			
			.user .dropdown {
				background-color: #1DA56D;
			}
			
			a.tasto:hover {
				color: white;
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
			
			<h1>Modifica password</h1>
			
			<form action="php/editprofile.php" method=POST>
				<p>
					<table id=dati>
						<tr>
							<td><b>Password attuale</b></td>
							<td>
								<input type=password name="password" pattern="(.{8,})" required />
								<?php if(isset($_GET["error"])&&$_GET["error"]=="old") echo " &nbsp <span style='color: red;'>
									<b>Password errata</b></span>"; ?>
							</td>
						</tr>
						
						<tr>
							<td><b>Nuova password</b></td>
							<td><input type=password name="newpassword1" pattern="(.{8,})" required />
								<?php if(isset($_GET["error"])&&$_GET["error"]=="equal") echo " &nbsp <span style='color: red;'>
									<b>La nuova password non deve essere uguale alla vecchia password!</b></span>"; ?>
							</td>
						</tr>
						<tr>
							<td><b>Ripeti nuova password</b></td>
							<td><input type=password name="newpassword2" pattern="(.{8,})" required />
								<?php if(isset($_GET["error"])&&$_GET["error"]=="new") echo " &nbsp <span style='color: red;'>
									<b>Le nuove password non coincidono</b></span>"; ?></td>
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
	</body>
</html>