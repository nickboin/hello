<?php
include("connetti.php");
//Create table Evento structure
$table = "Evento";
$sql = "CREATE TABLE IF NOT EXISTS ".$table." (
    id INTEGER NOT NULL AUTO_INCREMENT,
    titolo VARCHAR(50) NOT NULL,
    data DATETIME NOT NULL,
    descrizione TEXT,
    completato TINYINT NOT NULL,
    tabaccheria INTEGER NOT NULL,
    comune VARCHAR(75) NOT NULL,
    provincia VARCHAR(2) NOT NULL,
    FOREIGN KEY (tabaccheria) REFERENCES Tabaccheria(numero),
    FOREIGN KEY (comune) REFERENCES Comune(nome),
    FOREIGN KEY (provincia) REFERENCES Provincia(sigla),
    PRIMARY KEY(id)) DEFAULT CHARSET=utf8;";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Table ".$table." created ";
} else {
    echo " Error creating  ".$table." table : " . $conn -> error ;
}
echo "<br>";
?>