Visualizza l'hash di una stringa
<form action="hash.php" method=get>
    <input type='text' name='text'/> <input type='submit'/>
</form>
<?php
    if (isset($_GET["text"])) {
        echo "<br>Hash MD5: ".hash('md5',$_GET["text"]);
        echo "<br>Hash SHA-256: ".hash('sha256',$_GET["text"]);
        echo "<br>Hash SHA-512: ".hash('sha512',$_GET["text"]);
    }
?>