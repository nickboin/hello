<?php
include 'connetti.php';
$username = $_POST["username"];
$password = $_POST["password"];
$password = hash("sha512", $password);

$sql = "SELECT * FROM Utenti WHERE username='".$username."' AND password='".$password."';";
$result = mysqli_query($conn, $sql);
if ($result == false) {
    $_SESSION["dettagli_errore"] ="Errore nel login!";
    $_SESSION["titolo_errore"] = mysql_error();
    header("Location: php/error.php");
}

if(mysqli_num_rows($result) == 1){
    session_start();
    $user_row = mysqli_fetch_array($result);
    $_SESSION['user'] = $user_row['username'];
    $_SESSION['password'] = $password;
    $_SESSION['nome'] = $user_row['nome'];
    $_SESSION['num_tabaccheria'] = $user_row['tabaccheria'];
    $_SESSION['provincia'] = $user_row['provincia'];
    $_SESSION['comune'] = $user_row['comune'];
    header("location: ../main.php");
}
 else {
     header('Location: ../login.php?login=error'); //errore di login
}

?>