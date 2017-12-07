<?php
   include("php/session.php");
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Tabaccheria Online</title>
        <link rel="shortcut icon" href="images/icon.ico">
        <link rel="stylesheet" href="css/navigation.css">
        <link rel="stylesheet" href="css/gestionale.css">
        <link rel="stylesheet" href="css/base.css">
        <style>
            .boxgrande {
                width: 100%;
                top: auto;
                bottom: auto;
            }
            .calcbox {
                position: relative;
                border: double 3px black;
                border-radius: 8px;
                padding: 15px;
                background: white;
                width: 410px;
                margin: 5% auto 0 auto;
                text-align: center;
            }

            input {
                border: solid 1px black;
                background-color: white;
                padding: 10px;
                font-family: Arial, sans-serif;
                font-size: 24px;
            }

            input[type=button] {
                border: none;
                width: 80px;
            }

            input[type=button]:hover {
                background-color: gray;
            }
        </style>
    </head>

    <body>
        <!--NAVIGATION MENU-->
        <?php
                $page_active="calcolatrice";
                include("navigation.php");
        ?>

        <div class=box>
            <div class="calcbox">
                <table style="margin: 5px;">
                    <tr>
                        <td colspan=3><input id=display type=text onkeypress="return valido(event);" onkeydown="tastocanc(event)"
                                autofocus title="Se vuoi puoi usare la tastiera fisica! :)" /></td>
                        <td><input type=button value='C' onclick="pulisci()"/></td>
                    </tr>
                    <tr>
                        <td><input type=button onclick="numero(7)" value="7"/></td>
                        <td><input type=button onclick="numero(8)" value="8"/></td>
                        <td><input type=button onclick="numero(9)" value="9"/></td>
                        <td><input type=button onclick='operazione("+")' value="+"/></td>
                    </tr>
                    <tr>
                        <td><input type=button onclick="numero(4)" value="4"/></td>
                        <td><input type=button onclick="numero(5)" value="5"/></td>
                        <td><input type=button onclick="numero(6)" value="6"/></td>
                        <td><input type=button onclick='operazione("-")' value="-"/></td>
                    </tr>
                    <tr>
                        <td><input type=button onclick="numero(1)" value="1"/></td>
                        <td><input type=button onclick="numero(2)" value="2"/></td>
                        <td><input type=button onclick="numero(3)" value="3"/></td>
                        <td><input type=button onclick='operazione("*")' value="x"/></td>
                    </tr>
                    <tr>
                        <td colspan='2'><input type=button onclick="numero(0)" value="0" style="width:190px;"/></td>
                        <td><input type=button onclick="punto()" value="."/></td>
                        <td><input type=button onclick='operazione("/");' value=":"/></td>
                    </tr>
                    <tr>
                        <td><input type=button onclick='operazione("iva")' value="IVA"/></td>
                        <td><input type=button onclick='operazione("%")' value="%"/></td>
                        <td colspan='2'><input type=button onclick='operazione("=");' value="=" style="width:190px;"/></td>
                    </tr>
                </table>
            </div>
        </div>
        <!--carica per ultimi-->
        <script>
                var risultato = 0;
                var operando = "+";
                var cliccatoOperazione = false;
                var disp = document.getElementById("display");

                function valido(event) {
                        if (event.charCode >= 48 && event.charCode <= 57) { //input numeri
                                if (cliccatoOperazione) {
                                        disp.value = "";
                                        cliccatoOperazione = false;
                                }
                                return true; }
                        else if (event.charCode==43) { //operaazione somma
                                operazione("+");
                                return false;
                        } else if (event.charCode==45) { //operaazione sottrazione
                                operazione("-");
                                return false;
                        } else if (event.charCode==42) { //operaazione moltiplicazione
                                operazione("*");
                                return false;
                        } else if (event.charCode==47) { //operaazione divisione
                                operazione("/");
                                return false;
                        } else if (event.charCode==37) { //operaazione percentuale
                                operazione("%");
                                return false;
                        } else if (event.charCode==73||event.charCode==105) { //operaazione iva
                                operazione("iva");
                                return false;
                        } else if (event.charCode==13) { //operaazione uguale
                                operazione("=");
                                return false;
                        } else if (event.charCode==46) { //punto
                                if (disp.value.includes(".")) {
                                        return false;
                                }
                        } else if (event.charCode==44) { //virgola
                                if (!disp.value.includes(".")) {
                                        disp.value = disp.value + ".";
                                }
                                return false;
                        } else if (event.charCode==67||event.charCode==99) { //tasto c
                                pulisci();
                                return false;
                        }
                        else {	//input non ammesso
                                return false;
                        }
                }

                function tastocanc(event) {
                        if (event.keyCode==46) { //tasto canc
                                pulisci();
                        }
                        return false;
                }

                function operazione(op) {
                        cliccatoOperazione = true;
                        if (operando=="+") {
                                risultato += parseFloat(disp.value);
                        } else if (operando=="-") {
                                risultato -= parseFloat(disp.value);
                        } else if (operando=="*") {
                                risultato *= parseFloat(disp.value);
                        } else if (operando=="/") {
                                risultato /= parseFloat(disp.value);
                        } else if (operando=="%") {
                                risultato = risultato * parseFloat(disp.value) / 100;
                        } else if (operando=="=") {
                                operando = op;
                        } else {
                                disp.value = "??";
                        }
                        operando = op;
                        if (op=="=") {
                                disp.value = risultato;
                        } else if (op=="iva") {
                                risultato = parseFloat(disp.value);
                                disp.value = disp.value * 0.22;
                                cliccatoOperazione = false;
                                operando = "+";
                        }
                }

                function pulisci() {
                        operando = "+";
                        disp.value = "";
                        risultato = 0;
                        return true;
                }

                function numero(num) {
                        if (cliccatoOperazione) {
                                disp.value = "";
                                cliccatoOperazione = false;
                        }
                        disp.value = "" + disp.value + num;
                }

                function punto() {
                        if (!disp.value.includes(".")) {
                                disp.value = disp.value + ".";
                        }
                }

        </script>

        <img class=background_img src="images\background2.jpg">
    </body>
</html>