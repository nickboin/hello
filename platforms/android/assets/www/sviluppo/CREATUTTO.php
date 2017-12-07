<?php
include ("connetti.php");

//cancella il db per pulizia ed evitare problemi
$sql="DROP DATABASE `tabaccando`;";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Database cancellato";
} else {
    echo " Problemi nella cancellazione del database : " . $conn -> error ;
}

// Create new connection
$conn = new mysqli ( "localhost" , "root" , "" );
// Check connection
if ($conn -> connect_error ) {
    die (" Connection failed : " . $conn -> connect_error . "<br>" );
} else {
    echo "Connesso al dbms, bravo!<br>" ;
}
// Create database
$sql = "CREATE DATABASE Tabaccando";
if ($conn -> query ( $sql ) == TRUE ) {
    echo "Database Tabaccando created successfully<br>";
} else {
    echo "Error creating database Tabaccando<br>";
}

//seleziona il database
mysqli_select_db($conn,"Tabaccando");

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

//query inserimento regioni
$sql="INSERT INTO `regione` (`nome`) VALUES ('Abruzzo'),('Basilicata'),('Calabria'),('Campania'),('Emilia-Romagna'),
                                            ('Friuli-Venezia Giulia'),('Lazio'),('Liguria'),('Lombardia'),('Marche'),
                                            ('Molise'),('Piemonte'),('Puglia'),('Sardegna'),('Sicilia'),
                                            ('Toscana'),('Trentino-Alto Adige'),('Umbria'),('Valle d\'Aosta'),('Veneto');";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Regioni inserite ";
} else {
    echo " Errore nell'inserimento delle regioni: " . $conn -> error ;
}
echo "<br>";

//query inserimento provincie
$sql="INSERT INTO `provincia` (`nome`, `sigla`, `regione`) VALUES
    ('Agrigento', 'AG', 'Sicilia'),
    ('Alessandria', 'AL', 'Piemonte'),
    ('Ancona', 'AN', 'Marche'),
    ('Arezzo', 'AR', 'Toscana'),
    ('Ascoli Piceno', 'AP', 'Marche'),
    ('Asti', 'AT', 'Piemonte'),
    ('Avellino', 'AV', 'Campania'),
    ('Bari', 'BA', 'Puglia'),
    ('Barletta-Andria-Trani', 'BT', 'Puglia'),
    ('Belluno', 'BL', 'Veneto'),
    ('Benevento', 'BN', 'Campania'),
    ('Bergamo', 'BG', 'Lombardia'),
    ('Biella', 'BI', 'Piemonte'),
    ('Bologna', 'BO', 'Emilia-Romagna'),
    ('Bolzano', 'BZ', 'Trentino-Alto Adige'),
    ('Brescia', 'BS', 'Lombardia'),
    ('Brindisi', 'BR', 'Puglia'),
    ('Cagliari', 'CA', 'Sardegna'),
    ('Caltanissetta', 'CL', 'Sicilia'),
    ('Campobasso', 'CB', 'Molise'),
    ('Carbonia-Iglesias', 'CI', 'Sardegna'),
    ('Caserta', 'CE', 'Campania'),
    ('Catania', 'CT', 'Sicilia'),
    ('Catanzaro', 'CZ', 'Calabria'),
    ('Chieti', 'CH', 'Abruzzo'),
    ('Como', 'CO', 'Lombardia'),
    ('Cosenza', 'CS', 'Calabria'),
    ('Cremona', 'CR', 'Lombardia'),
    ('Crotone', 'KR', 'Calabria'),
    ('Cuneo', 'CN', 'Piemonte'),
    ('Enna', 'EN', 'Sicilia'),
    ('Fermo', 'FM', 'Marche'),
    ('Ferrara', 'FE', 'Emilia-Romagna'),
    ('Firenze', 'FI', 'Toscana'),
    ('Foggia', 'FG', 'Puglia'),
    ('Forlì-Cesena', 'FC', 'Emilia-Romagna'),
    ('Frosinone', 'FR', 'Lazio'),
    ('Genova', 'GE', 'Liguria'),
    ('Gorizia', 'GO', 'Friuli-Venezia Giulia'),
    ('Grosseto', 'GR', 'Toscana'),
    ('Imperia', 'IM', 'Liguria'),
    ('Isernia', 'IS', 'Molise'),
    ('L\'Aquila', 'AQ', 'Abruzzo'),
    ('La Spezia', 'SP', 'Liguria'),
    ('Latina', 'LT', 'Lazio'),
    ('Lecce', 'LE', 'Puglia'),
    ('Lecco', 'LC', 'Lombardia'),
    ('Livorno', 'LI', 'Toscana'),
    ('Lodi', 'LO', 'Lombardia'),
    ('Lucca', 'LU', 'Toscana'),
    ('Macerata', 'MC', 'Marche'),
    ('Mantova', 'MN', 'Lombardia'),
    ('Massa e Carrara', 'MS', 'Toscana'),
    ('Matera', 'MT', 'Basilicata'),
    ('Medio Campidano', 'VS', 'Sardegna'),
    ('Messina', 'ME', 'Sicilia'),
    ('Milano', 'MI', 'Lombardia'),
    ('Modena', 'MO', 'Emilia-Romagna'),
    ('Monza e Brianza', 'MB', 'Lombardia'),
    ('Napoli', 'NA', 'Campania'),
    ('Novara', 'NO', 'Piemonte'),
    ('Nuoro', 'NU', 'Sardegna'),
    ('Ogliastra', 'OG', 'Sardegna'),
    ('Olbia-Tempio', 'OT', 'Sardegna'),
    ('Oristano', 'OR', 'Sardegna'),
    ('Padova', 'PD', 'Veneto'),
    ('Palermo', 'PA', 'Sicilia'),
    ('Parma', 'PR', 'Emilia-Romagna'),
    ('Pavia', 'PV', 'Lombardia'),
    ('Perugia', 'PG', 'Umbria'),
    ('Pesaro e Urbino', 'PU', 'Marche'),
    ('Pescara', 'PE', 'Abruzzo'),
    ('Piacenza', 'PC', 'Emilia-Romagna'),
    ('Pisa', 'PI', 'Toscana'),
    ('Pistoia', 'PT', 'Toscana'),
    ('Pordenone', 'PN', 'Friuli-Venezia Giulia'),
    ('Potenza', 'PZ', 'Basilicata'),
    ('Prato', 'PO', 'Toscana'),
    ('Ragusa', 'RG', 'Sicilia'),
    ('Ravenna', 'RA', 'Emilia-Romagna'),
    ('Reggio Calabria(metropolitana)', 'RC', 'Calabria'),
    ('Reggio Emilia', 'RE', 'Emilia-Romagna'),
    ('Rieti', 'RI', 'Lazio'),
    ('Rimini', 'RN', 'Emilia-Romagna'),
    ('Roma', 'RM', 'Lazio'),
    ('Rovigo', 'RO', 'Veneto'),
    ('Salerno', 'SA', 'Campania'),
    ('Sassari', 'SS', 'Sardegna'),
    ('Savona', 'SV', 'Liguria'),
    ('Siena', 'SI', 'Toscana'),
    ('Siracusa', 'SR', 'Sicilia'),
    ('Sondrio', 'SO', 'Lombardia'),
    ('Taranto', 'TA', 'Puglia'),
    ('Teramo', 'TE', 'Abruzzo'),
    ('Terni', 'TR', 'Umbria'),
    ('Torino', 'TO', 'Piemonte'),
    ('Trapani', 'TP', 'Sicilia'),
    ('Trento', 'TN', 'Trentino-Alto Adige'),
    ('Treviso', 'TV', 'Veneto'),
    ('Trieste', 'TS', 'Friuli-Venezia Giulia'),
    ('Udine', 'UD', 'Friuli-Venezia Giulia'),
    ('Aosta', 'AO', 'Valle d\'Aosta'),
    ('Varese', 'VA', 'Lombardia'),
    ('Venezia', 'VE', 'Veneto'),
    ('Verbano-Cusio-Ossola', 'VB', 'Piemonte'),
    ('Vercelli', 'VC', 'Piemonte'),
    ('Verona', 'VR', 'Veneto'),
    ('Vibo Valentia', 'VV', 'Calabria'),
    ('Vicenza', 'VI', 'Veneto'),
    ('Viterbo', 'VT', 'Lazio');";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Provincie inserite ";
} else {
    echo " Errore nell'inserimento provincie : " . $conn -> error ;
}
echo "<br>";

//query inserimento comuni
include("insert_comuni_include.php");


//query inserimento tabacceria
$sql="INSERT INTO `tabaccheria` (`numero`, `piva`, `nome`, `localita`, `indirizzo`, `n_civico`, `tel`, `fax`, `comune`, `provincia`, `ordine_to_magazzino`) VALUES
    ('9', '12345678901', 'Gioachin Claudio', 'Villafora', 'Via Maggiore', '1620', '0425562224', '0425562958', 'Badia Polesine', 'RO', '1'),
    ('2', '01234567890', 'Bar Brutto', 'Canda', 'Via canda', '20', '0425123456', '0000000000', 'Canda', 'RO', '1');";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Alcune tabaccherie (2) inserite ";
} else {
    echo " Errore nell'inserimento delle tabaccherie : " . $conn -> error ;
}
echo "<br>";


//query inserimento utenti
$sql="INSERT INTO `utenti` (`username`, `password`, `nome`, `cognome`, `email`, `cf`, `ruolo`, `admin`, `datanascita`, `tabaccheria`, `comune`, `provincia`) VALUES
    ('admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec'
    , 'Amministratore', 'admin', 'admin@admin.it', 'ADMINADMINADMIN0', 'Grande Capo', '1', '1972-01-31', '9', 'Badia Polesine', 'RO'),
    ('nick', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86'
    , 'Nicholas', 'Boin', 'nicholas.boin@gmail.com', 'BNONHL98H24L359K', 'Dipendente', '0', '1998-06-24', '9', 'Badia Polesine', 'RO'),
    ('canda', '49de0748f516e897e519079f21204cb2ef62b62fbc06ba284f03e3543cbb222ad0f60535b071f9aba099123f56dde24fb5cac1846def3f13777bafe51dbf53b7'
    , 'Cin', 'Ciun Cian', 'cin.ciu.cian@pixel.jp', '', 'Proprietario', '1', '1969-02-14', '2', 'Canda', 'RO');";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Alcuni utenti inseriti: ( username -> password )  nick -> password , admin -> admin , canda -> candacaccia";
} else {
    echo " Errore nell'inserimento degli utenti : " . $conn -> error ;
}
echo "<br>";


//query inserimento tabacchi sample
$sql="INSERT INTO `tabacco`(`aams_code`, `barcode`, `tipologia`, `prezzo_unitario`, `pacchetto`, `descrizione`, `prezzo_stecca`, `qta_stecca`, `barcode_stecca`) VALUES
    ('13', '135684551684' , 'Sigarette', '5.4', '20', 'Marlboro Red', '54', '10', '561524889465'),
    ('113', '2649' , 'Sigarette', '2.7', '10', 'Marlboro Red', '54', '20', '5191256+29'),
    ('25', '948615' , 'Sigarette', '5', '20', 'MS Bionde', '50', '10', '44165684956'),
    ('125', '7852785274' , 'Sigarette', '2.5', '10', 'MS Bionde', '50', '20', '78542787527'),
    ('48', '278727853' , 'Sigarette', '4.8', '20', 'Philip Morris Blue', '48', '10', '56152532748257'),
    ('85', '7485767857' , 'Sigarette', '5.2', '20', 'Merit Yellow', '52', '10', '48453489465'),
    ('134', '135684551684' , 'Sigarette', '5.4', '20', 'Marlboro Light', '54', '10', '28767453278'),
    ('177', '7587752786' , 'Sigarette', '5', '20', 'Marlboro Medium', '50', '10', '278578777777'),
    ('9', '274852758' , 'Sigarette', '5.2', '20', 'Marlboro Touch', '52', '10', '785278278'),
    ('77', '3785357458' , 'Sigarette', '4.6', '20', 'Camel Double Activate', '46', '10', '2519715975419'),
    ('413', '5337537458327' , 'Sigari', '2.9', '10', 'Cafè Creme', '29', '10', '8545695');";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Alcuni tabacchi inseriti";
} else {
    echo " Errore nell'inserimento degli utenti : " . $conn -> error ;
}
echo "<br>";


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


/*

//query inserimento ...
$sql="INSERT INTO `` (``, ``, ``) VALUES
    ('', '', ''),
    ('', '', '');";
if ($conn -> query ( $sql ) == TRUE ) {
    echo "  inserite ";
} else {
    echo " Errore nell'inserimento  : " . $conn -> error ;
}
echo "<br>";

*/


?>