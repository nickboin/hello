<ul class=nav>
	<li class=nav><img src="<?php if(isset($php_dir)&&$php_dir) echo "../"; ?>images/tabaccheria.png" height=40></li>
	<li class=nav><a <?php if($page_active=="main") echo "class=active"; ?> href="<?php if(isset($php_dir)&&$php_dir) echo "../"; ?>main.php">HOME</a></li>
	<li class=nav><a <?php if($page_active=="magazzino") echo "class=active"; ?> href="<?php if(isset($php_dir)&&$php_dir) echo "../"; ?>magazzino.php">MAGAZZINO</a></li>
	<li class=nav><a <?php if($page_active=="ordine") echo "class=active"; ?> href="<?php if(isset($php_dir)&&$php_dir) echo "../"; ?>ordine.php">ORDINE</a></li>
	<li class=nav><a <?php if($page_active=="tabacchi") echo "class=active"; ?> href="<?php if(isset($php_dir)&&$php_dir) echo "../"; ?>tabacchi.php">TABACCO</a></li>
	<li class=nav><a <?php if($page_active=="vendite") echo "class=active"; ?> href="<?php if(isset($php_dir)&&$php_dir) echo "../"; ?>vendite.php">VENDITE</a></li>
	<li class=nav><a <?php if($page_active=="calcolatrice") echo "class=active"; ?> href="<?php if(isset($php_dir)&&$php_dir) echo "../"; ?>calcolatrice.php">CALCOLATRICE</a></li>
	<li class=nav><a <?php if($page_active=="eventi") echo "class=active"; ?> href="<?php if(isset($php_dir)&&$php_dir) echo "../"; ?>eventi.php">EVENTI</a></li>
	<li class=nav><a <?php if($page_active=="supporto") echo "class=active"; ?> href="<?php if(isset($php_dir)&&$php_dir) echo "../"; ?>support.php">SUPPORTO</a></li>
	<li class=user><a class=dropdown id=user><?php echo $logged_user_nome; ?></a>
		<div class=user-content>
			<a href="<?php if(isset($php_dir)&&$php_dir) echo "../"; ?>profile.php">MODIFICA</a>
			<a href="<?php if(isset($php_dir)&&$php_dir) {} else { echo "php/"; } ?>logout.php">ESCI</a>
		</div>
	</li>
	<?php
	$banana = "";
	if(isset($php_dir)&&$php_dir)
		$banana = "../";
	if ($user_db_row["admin"]==1) echo "<li class=tabaccheria><a class=dropdown id=user>BAR: ".$tabaccheria_nome."</a>\n
		<div class=tabaccheria-content>\n
			<a href='".$banana."tabaccheria.php'>GESTISCI</a>\n
		</div>\n
	</li>";
	?>
</ul>