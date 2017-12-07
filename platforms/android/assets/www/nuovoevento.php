<?php
   include("php/session.php");
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nuovo evento - Tabaccheria Online</title>
        <link rel="shortcut icon" href="images/icon.ico">
        <link rel="stylesheet" href="css/navigation.css">
        <link rel="stylesheet" href="css/gestionale.css">
        <link rel="stylesheet" href="css/tableforms.css">
        <link rel="stylesheet" href="css/forms.css">
        <link rel="stylesheet" href="css/base.css">
    </head>

    <body>
        <!--NAVIGATION MENU-->
        <?php
            $page_active="eventi";
            include("navigation.php");
            $data = isset($_GET['timestamp']) ? date('Y-m-d',$_GET['timestamp']) : date('Y-m-d');
        ?>
        <div class=box>
            <h1>Nuovo evento</h1>
            <form action="php/newevento.php" method="POST">
                <table id="dati">
                    <tr>
                        <td><b>Titolo</b>:</td>
                        <td>
                            <input type=text maxlength="50" name="titolo" style="width:100%" required />
                        </td>
                    </tr>
                    <tr>
                        <td><b>Descrizione</b>:</td>
                        <td>
                            <input type=text name="descrizione" style="width:100%"/>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Data</b>:</td>
                        <td>
                            <input type=date name="data" value="<?php echo $data;?>"/> &nbsp; 
                            <b>Ora</b>: &nbsp; <input type=number max=23 min=0 name="ora" required /><b>:</b><input type=number max=59 min=0 name="minuto" required />
                        </td>
                    </tr>
                </table>
                <div class=apply>
                    <input type=button class=tasto value='ANNULLA' onclick="window.location.href='eventi.php';" />
                    <input type=submit class=tasto value='INSERISCI' />
                </div>
            </form>
        </div>
        <!--carica per ultimi-->
        <img class=background_img src="images\background2.jpg">
    </body>
</html>