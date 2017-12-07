<?php

include("connetti.php");

//Create table Regione structure
$table = "Regione";
$sql = "CREATE TABLE IF NOT EXISTS ".$table." (
    nome VARCHAR(22) NOT NULL,
    PRIMARY KEY(nome)) DEFAULT CHARSET=utf8;";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Table ".$table." created ";
} else {
    echo " Error creating  ".$table." table : " . $conn -> error ;
}
echo "<br>";


//Create table Provincia structure
$table = "Provincia";
$sql = "CREATE TABLE IF NOT EXISTS ".$table." (
    sigla VARCHAR(2) NOT NULL,
    nome VARCHAR(25) NOT NULL,
    regione VARCHAR(22) NOT NULL,
    PRIMARY KEY(sigla),
    FOREIGN KEY (regione) REFERENCES Regione(nome)) DEFAULT CHARSET=utf8;";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Table ".$table." created ";
} else {
    echo " Error creating  ".$table." table : " . $conn -> error ;
}
echo "<br>";


//Create table Comune structure
$table = "Comune";
$sql = "CREATE TABLE IF NOT EXISTS ".$table." (
    nome VARCHAR(75) NOT NULL,
    provincia VARCHAR(2) NOT NULL,
    cap VARCHAR(5) NOT NULL,
    FOREIGN KEY (provincia) REFERENCES Provincia(sigla),
    PRIMARY KEY CLUSTERED (nome,provincia)) DEFAULT CHARSET=utf8;";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Table ".$table." created ";
} else {
    echo " Error creating  ".$table." table : " . $conn -> error ;
}
echo "<br>";



//Create table Tabacco structure
$table = "Tabacco";
$sql = "CREATE TABLE IF NOT EXISTS ".$table." (
    aams_code INTEGER NOT NULL,
    barcode BIGINT,
    tipologia VARCHAR(30) NOT NULL,
    prezzo_unitario FLOAT NOT NULL,
    pacchetto INTEGER NOT NULL,
    descrizione TEXT,
    prezzo_stecca FLOAT NOT NULL,
    qta_stecca INTEGER,
    barcode_stecca BIGINT,
    PRIMARY KEY (aams_code)) DEFAULT CHARSET=utf8;";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Table ".$table." created ";
} else {
    echo " Error creating  ".$table." table : " . $conn -> error ;
}
echo "<br>";


//Create table Tabaccheria structure
$table = "Tabaccheria";
$sql = "CREATE TABLE IF NOT EXISTS ".$table." (
    numero INTEGER NOT NULL,
    piva VARCHAR (11) NOT NULL,
    nome TEXT NOT NULL,
    localita TEXT,
    indirizzo TEXT,
    n_civico VARCHAR(10),
    tel VARCHAR(16),
    fax VARCHAR(16),
    ordine_to_magazzino TINYINT NOT NULL,
    comune VARCHAR(75) NOT NULL,
    provincia VARCHAR(2) NOT NULL,
    FOREIGN KEY (comune) REFERENCES Comune(nome),
    FOREIGN KEY (provincia) REFERENCES Provincia(sigla),
    PRIMARY KEY CLUSTERED (numero,comune,provincia)) DEFAULT CHARSET=utf8;";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Table ".$table." created ";
} else {
    echo " Error creating  ".$table." table : " . $conn -> error ;
}
echo "<br>";


//Create table Magazzino structure
$table = "Magazzino";
$sql = "CREATE TABLE IF NOT EXISTS ".$table." (
    tabaccheria INTEGER NOT NULL,
    comune VARCHAR(75) NOT NULL,
    provincia VARCHAR(2) NOT NULL,
    aams_code INTEGER NOT NULL,
    pezzi INTEGER NOT NULL,
    FOREIGN KEY (tabaccheria) REFERENCES Tabaccheria(numero),
    FOREIGN KEY (comune) REFERENCES Comune(nome),
    FOREIGN KEY (provincia) REFERENCES Provincia(sigla),
    FOREIGN KEY (aams_code) REFERENCES Tabacco(aams_code),
    PRIMARY KEY CLUSTERED (aams_code,tabaccheria,comune,provincia)) DEFAULT CHARSET=utf8;";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Table ".$table." created ";
} else {
    echo " Error creating  ".$table." table : " . $conn -> error ;
}
echo "<br>";


//Create table Ordine structure
$table = "Ordine";
$sql = "CREATE TABLE IF NOT EXISTS ".$table." (
    numero INTEGER NOT NULL AUTO_INCREMENT,
    tabaccheria INTEGER NOT NULL,
    comune VARCHAR(75) NOT NULL,
    provincia VARCHAR(2) NOT NULL,
    data_creazione DATETIME NOT NULL,
    data_aggiornamento DATETIME,
    data_evasione DATETIME,
    data_spedizione DATE,
    FOREIGN KEY (tabaccheria) REFERENCES Tabaccheria(numero),
    FOREIGN KEY (comune) REFERENCES Comune(nome),
    FOREIGN KEY (provincia) REFERENCES Provincia(sigla),
    PRIMARY KEY CLUSTERED (numero,tabaccheria,comune,provincia)) DEFAULT CHARSET=utf8;";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Table ".$table." created ";
} else {
    echo " Error creating  ".$table." table : " . $conn -> error ;
}
echo "<br>";


//Create table Ordinato structure
$table = "Ordinato";
$sql = "CREATE TABLE IF NOT EXISTS ".$table." (
    aams_code INTEGER NOT NULL,
    numero_ordine INTEGER NOT NULL,
    tabaccheria INTEGER NOT NULL,
    comune VARCHAR(75) NOT NULL,
    provincia VARCHAR(2) NOT NULL,
    pezzi INTEGER NOT NULL,
    FOREIGN KEY (aams_code) REFERENCES Tabacco(aams_code),
    FOREIGN KEY (numero_ordine) REFERENCES Ordine(numero),
    FOREIGN KEY (tabaccheria) REFERENCES Tabaccheria(numero),
    FOREIGN KEY (comune) REFERENCES Comune(nome),
    FOREIGN KEY (provincia) REFERENCES Provincia(sigla),
    PRIMARY KEY CLUSTERED (aams_code,numero_ordine,tabaccheria,comune,provincia)) DEFAULT CHARSET=utf8;";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Table ".$table." created ";
} else {
    echo " Error creating  ".$table." table : " . $conn -> error ;
}
echo "<br>";


//Create table Utenti structure
$table = "Utenti";
$sql = "CREATE TABLE IF NOT EXISTS ".$table." (
    username VARCHAR(30) NOT NULL,
    email TEXT NOT NULL,
    password VARCHAR(128) NOT NULL,
    nome VARCHAR(30) NOT NULL,
    cognome VARCHAR(30),
    cf VARCHAR(16),
    immagine TEXT,
    ruolo VARCHAR(30),
    admin BOOLEAN NOT NULL,
    datanascita DATE,
    tabaccheria INTEGER NOT NULL,
    comune VARCHAR(75) NOT NULL,
    provincia VARCHAR(2) NOT NULL,
    FOREIGN KEY (tabaccheria) REFERENCES Tabaccheria(numero),
    FOREIGN KEY (comune) REFERENCES Comune(nome),
    FOREIGN KEY (provincia) REFERENCES Provincia(sigla),
    PRIMARY KEY(username)) DEFAULT CHARSET=utf8;";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Table ".$table." created ";
} else {
    echo " Error creating  ".$table." table : " . $conn -> error ;
}
?>