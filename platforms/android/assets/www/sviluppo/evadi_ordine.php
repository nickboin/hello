<?php
$risultato="";
if (isset($_POST['data'])&&isset($_POST['numero'])&&isset($_POST['tabaccheria'])&&isset($_POST['comune'])&&isset($_POST['provincia'])) {
    include ("connetti.php");
    $data_ora=date("Y-m-d H:i:s",strtotime($_POST['data']));
    $numero=$_POST['numero'];
    $tabaccheria=$_POST['tabaccheria'];
    $comune=$_POST['comune'];
    $provincia=$_POST['provincia'];
    
    $sql="UPDATE ordine SET data_evasione = '".$data_ora."' WHERE numero = '".$numero."' AND tabaccheria = '".$tabaccheria
        ."' AND provincia = '".$provincia."' AND comune = '".$comune."';";
    if ($conn -> query ( $sql ) == TRUE ) {
        $result = $conn -> query ( "SELECT ordine_to_magazzino FROM Tabaccheria WHERE numero = '".$tabaccheria
                                    ."' AND provincia = '".$provincia."' AND comune = '".$comune."';" );
        if ($result!=false&&$result->fetch_array()[0]!=0)
            $risultato=aggiungiOrdineAlMagazzino($conn,$numero,$tabaccheria,$provincia,$comune);
        $risultato.="Ordine evaso il ".$data_ora."<br>";
    } else {
        $risultato="Errore nell'aggiornamento: " . $conn -> error . "<br>" ;
    }
}

function aggiungiOrdineAlMagazzino($conn,$numero_ordine,$tabaccheria,$provincia,$comune) {
    $string_result="";
    $result = $conn -> query ( "SELECT aams_code,pezzi FROM Ordinato WHERE numero_ordine='".$numero_ordine."' AND tabaccheria='"
            .$tabaccheria."' AND provincia='".$provincia."' AND comune='".$comune."';");
    if ( $result != FALSE ) {
        $righe = $result -> num_rows;
        for ($i=0;$i<$righe;$i++) {
            $row = $result -> fetch_assoc();
            $string_result.=aggiungi_magazzino($conn,$row["aams_code"],$row["pezzi"],$tabaccheria,$provincia,$comune);
        }
    }
    return $string_result;
}

function aggiungi_magazzino($conn,$aams,$pezzi_ordine,$tabaccheria,$provincia,$comune) {
    $string_result="";
    $result=mysqli_query($conn,"SELECT pezzi FROM Magazzino WHERE aams_code='".$aams."' AND tabaccheria = '".$tabaccheria
                ."' AND provincia = '".$provincia."' AND comune = '".$comune."';");
    if ($result == false) {
        echo mysqli_error($conn);
    } else {
        if(mysqli_num_rows($result)>0) { //c'è già, somma allora i pezzi
            $pezzi=(int)mysqli_fetch_array($result)[0];
            $pezzi+=(int)$pezzi_ordine;
            $result=mysqli_query($conn,"UPDATE Magazzino SET pezzi='".$pezzi."' WHERE aams_code='".$aams."' AND tabaccheria = '"
                .$tabaccheria."' AND provincia = '".$provincia."' AND comune = '".$comune."';");
            $string_result.="Aggiorno il magazzino con ".$pezzi." pezzi di aams ".$aams."<br/>";
            if ($result == false) {
                echo mysqli_error($conn);
            }
        } else {    //altrimenti manca, quindi inserisci
            $result=mysqli_query($conn,"INSERT INTO Magazzino(tabaccheria, comune, provincia, aams_code, pezzi) VALUES ('"
                    .$tabaccheria."', '".$comune."', '".$provincia."', '".$aams."', '".$pezzi_ordine."');");
            $string_result.="Inserisco nl magazzino ".$pezzi_ordine." pezzi di aams ".$aams."<br/>";
            if ($result == false) {
                echo mysqli_error($conn);
            }
        }
        return $string_result;
    }
    
}
?>
<html>
    <head><title>Evasione ordine</title></head>
    <body>
		<h1>Evadi furbescamente un ordine</h1>
		<form action="evadi_ordine.php" method="POST">
			<table>
				<tr>
					<td>Data di evasione*:</td>
					<td><input type='datetime-local' name="data"/></td>
				</tr>
				<tr>
					<td>Numero ordine*:</td>
					<td><input type=number name="numero"/></td>
				</tr>
				<tr>
					<td>Numero tabaccheria*:</td>
					<td><input type=number name="tabaccheria" min="1" required/></td>
				</tr>
				<tr>
					<td>Comune tabaccheria*:</td>
					<td><input type=text name="comune" maxlength=75 required/></td>
				</tr>
				<tr>
					<td>Sigla provincia tabaccheria*:</td>
					<td><input type=text name="provincia" maxlength=2 required/></td>
				</tr>
				<tr>
					<td></td>
					<td><br/><input type=submit /></td>
				</tr>
			</table>
		</form>
        <br><br></br>
        <?php
            if($risultato!=""&&$risultato!=null)
                echo "<center><h2>".$risultato."</h2></center>";
        ?>
    </body>
</html>