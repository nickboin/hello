<?php
$risultato=null;
if (isset($_POST['aams'])&&isset($_POST['tipologia'])&&isset($_POST['prezzo'])&&isset($_POST['pacchetto'])&&isset($_POST['prezzo_stecca'])) {
    include ("connetti.php");
    
    $sql = "INSERT INTO `tabacco` (`aams_code`, `tipologia`, `prezzo_unitario`, "; //variabili required
    //controlla se le variabili non required sono settate e le aggiunge al bisogno
    if (isset($_POST["barcode"])&&$_POST["barcode"]!="") {
        $sql.="`barcode`, "; }
    if (isset($_POST["barcode_stecca"])&&$_POST["barcode_stecca"]!="") {
        $sql.="`barcode_stecca`, "; }
    if (isset($_POST["qta_stecca"])&&$_POST["qta_stecca"]!="") {
        $sql.="`qta_stecca`, "; }
    if (isset($_POST["descrizione"])&&$_POST["descrizione"]!="") {
        $sql.="`descrizione`, "; }
    //inserisce variabili required
    $sql.="`pacchetto`, `prezzo_stecca`) VALUES ('".$_POST["aams"]."', '".$_POST["tipologia"]."', '".$_POST["prezzo"]."', '"; 
    //controlla se le variabili non required sono settate e le aggiunge al bisogno
    if (isset($_POST["barcode"])&&$_POST["barcode"]!="") {
        $sql.=$_POST["barcode"]."', '"; }
    if (isset($_POST["barcode_stecca"])&&$_POST["barcode_stecca"]!="") {
        $sql.=$_POST["barcode_stecca"]."', '"; }
    if (isset($_POST["qta_stecca"])&&$_POST["qta_stecca"]!="") {
        $sql.=$_POST["qta_stecca"]."', '"; }
    if (isset($_POST["descrizione"])&&$_POST["descrizione"]!="") {
        $sql.=$_POST["descrizione"]."', '"; }
    //aggiunge le rimanenti variabili required
    $sql.=$_POST["pacchetto"]."', '".$_POST["prezzo_stecca"]."');";
    if ($conn -> query ( $sql ) == TRUE ) {
       $risultato = "Pacchetto inserito, aams: ".$_POST["aams"];
    } else {
        $risultato="Errore nell'inserimento: " . $conn -> error ;
    }
}
?>
<html>
    <head><title>Inserisci tabacco</title></head>
    <body>
		<h1>Inserisci un tabacco</h1>
		<form action="newtabacco.php" method="POST">
			<table>
				<tr>
					<td>Codice aams*:</td>
					<td><input type=number name="aams" min=1 required/></td>
				</tr>
				<tr>
					<td>Tipologia*:</td>
					<td><input type=text name="tipologia" maxlength="30" required/></td>
				</tr>
				<tr>
					<td>Pacchetto da *:</td>
					<td><input type=number name="pacchetto" min=1 required/></td>
				</tr>
				<tr>
					<td>Prezzo unitario*:</td>
					<td><input type=number name="prezzo" min=0.05 step=0.05 required/></td>
				</tr>
				<tr>
					<td>Prezzo stecca*:</td>
					<td><input type=number name="prezzo_stecca" min=0.05 step=0.05 required/></td>
				</tr>
				<tr>
					<td>Quantità stecca:</td>
					<td><input type=number name="qta_stecca" min=1 step=1/></td>
				</tr>
				<tr>
					<td>Barcode stecca:</td>
					<td><input type=number name="barcode_stecca" min=0 step=1/></td>
				</tr>
				<tr>
					<td>Barcode pacchetto:</td>
					<td><input type=number name="barcode" min=0 step=1/></td>
				</tr>
				<tr>
					<td>Descrizione:</td>
					<td><input type=text name="descrizione"/></td>
				</tr>
				<tr>
					<td></td>
					<td><br/><input type=submit /></td>
				</tr>
			</table>
		</form>
        <br><br></br>
        <?php
            if($risultato!=null)
                echo "<center><h2>".$risultato."</h2></center>";
        ?>
    </body>
</html>