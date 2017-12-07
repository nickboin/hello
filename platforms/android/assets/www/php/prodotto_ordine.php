<?php
include("session.php");
date_default_timezone_set('Europe/Rome');

if (isset($_GET["act"])&&$_GET["act"]=="modifica") {
    echo "<html><body onload='document.forms[\"redirect\"].submit();'>
        <form action='../modificaordine.php?num=".$_GET["ordine"]."' method=POST name='redirect'>
        <input type=hidden name='modifica' value='".$_GET["aams"]."'/></form></body></html>";
} else if (isset($_GET["act"])&&$_GET["act"]=="elimina") {
    //mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0;");
    $sql="DELETE FROM Ordinato WHERE numero_ordine = '".$_GET["ordine"]."' 
        AND tabaccheria = '".$tabaccheria_numero."' AND provincia = '".$tabaccheria_provincia."' 
        AND comune = '".$tabaccheria_comune."' AND aams_code = '".$_GET["aams"]."';";
    $result = mysqli_query($conn, $sql);
    if ($result == false) {
        $_SESSION["dettagli_errore"] = mysqli_error($conn);
        $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL di eliminazione!";
        header("Location: error.php");
    }
    else {
		aggiornamento($conn,$_POST["ordine"]);
        header("Location: ../modificaordine.php?num=".$_GET["ordine"]); //eliminato con successo
    }
} else {
    if (isset($_POST["edited"])&&$_POST["edited"]=="1") {
        //mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0;");
        $sql = "UPDATE ordinato SET pezzi = '".$_POST["pezzi"]."' WHERE numero_ordine = '".$_POST["ordine"]."' 
						AND tabaccheria = '".$tabaccheria_numero."' AND provincia = '".$tabaccheria_provincia."' 
						AND comune = '".$tabaccheria_comune."' AND aams_code = '".$_POST["aams_code"]."';";
        $result = mysqli_query($conn, $sql);
        if ($result == false) {
            $_SESSION["dettagli_errore"] = mysqli_error($conn);
            $_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL di modifica!";
            header("Location: error.php");
        }
        else {
			aggiornamento($conn,$_POST["ordine"]);
            header("Location: ../modificaordine.php?num=".$_POST["ordine"]); //modificato con successo
        }
    } else {
		if(isset($_POST["aams_code"])&&!empty($_POST["aams_code"])&&isset($_POST["pezzi"])&&!empty($_POST["pezzi"])) {
			$sql = "INSERT INTO `ordinato` (`aams_code`, `numero_ordine`, `tabaccheria`, `provincia`, `comune`, `pezzi`)
				VALUES ('".$_POST["aams_code"]."', '".$_POST["ordine"]."', '".$tabaccheria_numero."', '".$tabaccheria_provincia."', '"
				.$tabaccheria_comune."', '".$_POST["pezzi"]."');";
			$result = mysqli_query($conn, $sql);
			if ($result == false) {
				$_SESSION["dettagli_errore"] = mysqli_error($conn);
				$_SESSION["titolo_errore"] ="Errore nell'inserimento oppure codice AAMS tabacco non valido!";
				header("Location: error.php");
			}
			else {
				if (isset($_POST["completo"])&&$_POST["completo"]=="1") {
					aggiornamento($conn,$_POST["ordine"]);
					header("Location: ../infoordine.php?act=rivedi&num=".$_POST["ordine"]);
				} else {
					aggiornamento($conn,$_POST["ordine"]);
					header("Location: ../modificaordine.php?num=".$_POST["ordine"]); //inserito con successo
				}
			}
		} else {
			aggiornamento($conn,$_POST["ordine"]);
			header("Location: ../infoordine.php?act=rivedi&num=".$_POST["ordine"]);
		}
    }
}

function aggiornamento($connessione_db,$num_ordine) {
	//aggiorna l'ultima modifica
	$sql = "UPDATE ordine SET data_aggiornamento = '".date('Y-m-d H:i:s')."' WHERE numero = '".$num_ordine."' 
					AND tabaccheria = '".$_SESSION['num_tabaccheria']."' AND provincia = '".$_SESSION['provincia']."' 
					AND comune = '".$_SESSION['comune']."';";
	$result = mysqli_query($connessione_db, $sql);
	if ($result == false) {
		$_SESSION["dettagli_errore"] = mysqli_error($connessione_db);
		$_SESSION["titolo_errore"] ="Errore nell'esecuzione del codice SQL di salvataggio ora aggiornamento!";
		header("Location: error.php");
	}
}
?>