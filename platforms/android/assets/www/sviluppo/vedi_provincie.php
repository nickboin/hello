<html>
    <head>
        <title>Provincie - elenco</title>
        <style>
            td { min-width: 60px; }
            th { text-align: left; }
        </style>
    </head>
    <body>
        <h1>Elenco delle provincie presenti nel database</h1><br/>
        <?php
        include ("../php/connetti.php");
        $sql = "SELECT * FROM Provincia";
        $result = mysqli_query($conn, $sql);
        if ($result == false) { echo $result->mysqli_error(); }
        else {
            echo "<table><tr><th>#</th><th>Nome</th><th>Sigla</th><th>Regione</th></tr>";
            
            
            for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                $row =mysqli_fetch_assoc($result);
                echo "<tr><td>".($i+1)."</td><td>".$row["nome"]."</td><td>".$row["sigla"]."</td><td>".$row["regione"]."</td></tr>";
                
            }
            echo "</table>";
        }
        ?>
        
    </body>
</html>