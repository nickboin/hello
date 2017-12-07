<?php
session_start();
$_SESSION["num_tabaccheria_reg"]="num";
$_SESSION["comune_reg"]="comune";
$_SESSION["provincia_reg"]="provincia";
$_SESSION["nome_tabaccheria_reg"]="nomebar";
header("Location: ../nuovoadmin.php");
?>