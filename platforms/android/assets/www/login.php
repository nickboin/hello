<?php
	if (isset($_GET["login"])&&$_GET["login"]=="error") {}	//se non arriva da un login errato, altrimenti tutto rischia di andare in un loop di redirect
	else {
		session_start();
		if (isset($_SESSION["password"])&&$_SESSION["password"]!="")	//probabilmente c'è una sessione aperta
			header("Location: main.php");	//redirect alla pagina main che controlla da sola l'effettivo login corretto
	}
?>
<html>
	<head>
		<title>Tabaccheria Online</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="images/icon.ico">
		<link rel="stylesheet" href="css/base.css">
		<link rel="stylesheet" href="css/placeholder.css">
		<style>
			h1 {
				font-family: Roboto, Arial, sans-serif;
				color: white;
				text-shadow: 0 0 15px black;
			}
			
			h1:hover {
				text-shadow: 0 0 15px #32D390;
			}
			
			.login {
				padding:10px 10px;
				margin:10px 0;
				border:none;
				background:#8C8C8C;
				font-family: "Roboto", Helvetica, Arial, sans-serif;
				text-decoration: none;
				color: white;
				width: 250px;
				}
			
			.login:hover, .login:active, .login:focus
				{ background:#24B67A; }
			
			.entra {
				font-family: "Roboto", sans-serif;
				background: #32D390;
				border: 0;
				margin:10px 0;
				padding: 10px;
				text-decoration: none;
				font-weight: bold;
				color: white;
				width: 250px;
			}
			
			.entra:hover
				{ background:#24B67A; }
			
			.box {
				background: #F2F2F2;
				position: absolute;
				padding-left: 10px;
				padding-right: 10px;
				padding-bottom: 10px;
				top: 50%;
				left: 50%;
				margin-top:-180px;
				margin-left:-135px;
				border-style: double;
				border-radius: 10px;
				border-color: navy;
			}
		</style>
	</head>

	<body>
		<h1>
			<a href="home.html" title="Homepage" style="color:white;">
				<img src="images\tabaccheria.png" style="vertical-align: middle; border: 2px solid; border-color: black" height=50px>
				&nbsp Gestionale WEB Tabaccheria
			</a>
		</h1>
		
		<div class=box>
			<p style="font-family:Arial,sans-serif; font-size: 24px; font-weight: bold;">Accedi</p>
			<form method="POST" action="php/loginaction.php">
				<input class=login type=text name="username" placeholder="Username" required/>
				<br/>
				<input class=login type=password name="password" placeholder="Password" required/>
				<br/>
				<div align=center>
					<input class=entra type=submit id=submit value="ENTRA"/>
				</div>
			</form>
			<div style="font-weight: bold; font-family: 'Roboto',Arial,sans-serif; font-size:14px;" id="esito"></div>
			
			<script>
				var QueryString = function () {
					// This function is anonymous, is executed immediately and 
					// the return value is assigned to QueryString!
					var query_string = {};
					var query = window.location.search.substring(1);
					var vars = query.split("&");
					for (var i=0;i<vars.length;i++) {
						var pair = vars[i].split("=");
						// If first entry with this name
						if (typeof query_string[pair[0]] === "undefined") {
							query_string[pair[0]] = decodeURIComponent(pair[1]);
						// If second entry with this name
						} else if (typeof query_string[pair[0]] === "string") {
							var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
							query_string[pair[0]] = arr;
						// If third or later entry with this name
						} else {
							query_string[pair[0]].push(decodeURIComponent(pair[1]));
						}
					} 
					return query_string;
				}();
				
				var login = QueryString.login;
				if (login=="error")
				{
					div=document.getElementById("esito");
					div.innerHTML="<img src='images/alert.png' height=20 style='vertical-align: middle;'/> &nbsp Login errato. Riprova.<br/><br/>";
					div.style.color="red";
				}
			</script>
			
			<div align=center style="font-size: 13px; font-family: 'Roboto',Arial,sans-serif;">
				<a class=colorato href="recupera.html" target="_blank"><b>Password dimenticata?</b></a><br/>•<br/>
				<a class=colorato href="inforeg.html">Registra la tua tabaccheria</a>
			</div>
		</div>
		
		<div class=footer>
			<a class=help href="mailto:amministratore@tabacchi.it?subject=Richiesto%20intervento%20portale%20tabaccai&body=Buongiorno,%20desideravo%20richiedere%20assistenza%20nel%20portale%20dei%20tabaccai%20online%20per%20la%20seguente%20motivazione:%20">
				Segnala problemi
			</a>
		</div>
		
		<!--carica per ultimi-->
		<img class=background_img src="images\background.jpg">
	</body>
</html>