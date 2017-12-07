<?php
include ('session.php');

if (isset($_POST["password"])) {    //controlla se l'intenzione è modificare la password
    $sql = "SELECT password FROM Utenti WHERE username='".$logged_user."';";    //preleva la password attuale
    $result = mysqli_query($conn, $sql);
    if ($result == false) { echo $result->mysqli_error(); }
    else {
        if(mysqli_fetch_array($result)[0]==hash("sha512",$_POST["password"])) {  //controlla se la password coincide con quella nel database
            if ($_POST["newpassword1"]==$_POST["newpassword2"]) { //controlla se la nuova password è stata digitata correttamente
                if ($_POST["newpassword1"]==$_POST["password"]) {   //controlla se la nuova password coincide con quella nuova
                    header("Location: ../editpw.php?error=equal");
                } else {
                    $sql = "UPDATE Utenti SET password='".hash("sha512",$_POST["newpassword1"])."' WHERE username='".$logged_user."';";    //salva nuova password
                    $result = mysqli_query($conn, $sql);
                    if ($result == false) { echo $result->mysqli_error(); }
                    else {
                        $_SESSION["password"]=hash("sha512",$_POST["newpassword1"]);
                        header("Location: ../profile.php#pw");
                    }
                }
            } else {    //nuova password digitata erratamente
                header("Location: ../editpw.php?error=new");
            }
        } else {    //password attuale errata
            header("Location: ../editpw.php?error=old");
        }
    }
} else {    //altrimenti l'intenzione è modificare il profilo
    $sql = "UPDATE Utenti SET ";    //inizia query per modifica dati utente
    $nome_field = explode(" ", $_POST["nome"], 2);  //spezza la stringa in base allo spazio
    if(count($nome_field)==2) {   //se è stata spezzata allora c'è anche il cognome
        //salva nome e cognome assicurando che siano lunghi al massimo 30 caratteri
        $sql .= "nome=\"".substr($nome_field[0],0,30)."\", cognome=\"".substr($nome_field[1],0,30)."\", ";
    } else
        $sql .= "nome=\"".substr($_POST["nome"],0,30)."\", ";   //salva il nome assicurando che sia lungo al massimo 30 caratteri
    //salva gli altri dati
    $sql .= "email=\"".$_POST["email"]."\", datanascita=\"".$_POST["datanascita"]."\" WHERE username=\"".$logged_user."\";";
    $result = mysqli_query($conn, $sql);
    if ($result == false) { echo mysqli_error($conn); }
    else {
        header("Location: ../profile.php#updated");
    }
}
?>