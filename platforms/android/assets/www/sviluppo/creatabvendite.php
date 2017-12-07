<?php
include("connetti.php");
//Create table Magazzino structure
$table = "Vendita";
$sql = "CREATE TABLE IF NOT EXISTS ".$table." (
    id INTEGER NOT NULL AUTO_INCREMENT,
    tabaccheria INTEGER NOT NULL,
    comune VARCHAR(75) NOT NULL,
    provincia VARCHAR(2) NOT NULL,
    aams_code INTEGER NOT NULL,
    pezzi INTEGER NOT NULL,
    data DATETIME NOT NULL,
    FOREIGN KEY (tabaccheria) REFERENCES Tabaccheria(numero),
    FOREIGN KEY (comune) REFERENCES Comune(nome),
    FOREIGN KEY (provincia) REFERENCES Provincia(sigla),
    FOREIGN KEY (aams_code) REFERENCES Tabacco(aams_code),
    PRIMARY KEY (id)) DEFAULT CHARSET=utf8;";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Table ".$table." created ";
} else {
    echo " Error creating  ".$table." table : " . $conn -> error ;
}
echo "<br>";