<?php
include ("connetti.php");

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
    echo " Alcune tabaccherie inserite ";
} else {
    echo " Errore nell'inserimento delle tabaccherie : " . $conn -> error ;
}
echo "<br>";


//query inserimento tabacceria
$sql="INSERT INTO `utenti` (`username`, `password`, `nome`, `cognome`, `email`, `cf`, `ruolo`, `admin`, `datanascita`, `tabaccheria`, `comune`, `provincia`) VALUES
    ('admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec'
    , 'Amministratore', 'admin', 'admin@admin.it', 'ADMINADMINADMIN0', 'Grande Capo', '1', '1972-01-31', '9', 'Badia Polesine', 'RO'),
    ('nick', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86'
    , 'Nicholas', 'Boin', 'nicholas.boin@gmail.com', 'BNONHL98H24L359K', 'Dipendente', '0', '1998-06-24', '9', 'Badia Polesine', 'RO');";
if ($conn -> query ( $sql ) == TRUE ) {
    echo " Alcune tabaccherie (1) inserite ";
} else {
    echo " Errore nell'inserimento delle tabaccherie : " . $conn -> error ;
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