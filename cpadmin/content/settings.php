<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
if(isset($_POST['doFormSave'])) {
	$configfile = '../system/config.php';

	$com_name 	= "";
	$com_addres = "";
	$com_telp 	= "";
	
	if(isset($_POST['com_name']))
		$com_name = $_POST['com_name'];
	if(isset($_POST['com_addres']))
		$com_addres = $_POST['com_addres'];
	if(isset($_POST['com_telp']))
		$com_telp = $_POST['com_telp'];
		
	if(!empty($ip_mt) && !empty($user_mt))
	{
		if(!is_writable('../system/config.php'))
			$error = true;
			
		if(empty($error))
		{
			# menulis konfigurasi
			$conf = file_get_contents('../system/config.php');
			$conf = preg_replace("/com_name.*;/i", 'com_name = "'.$com_name.'";', $conf);
			$conf = preg_replace("/com_addres.*;/i", 'com_addres = "'.$com_addres.'";', $conf);
			$conf = preg_replace("/com_telp.*;/i", 'com_telp = "'.$com_telp.'";', $conf);
			$cf = fopen('../system/config.php', 'w');
			fwrite($cf, $conf);
			fclose($cf);

		$saved = true;
		}
	}
}
?>
<section id="pane">
	<header>
		<h1><?php echo $lang_com_set;?></h1>
		<nav class="breadcrumbs">
			<ul>
				<li class="alt"><a href="./"><i class="icon-home"></i></a></li>
				<li><a href="index.php"><?php echo $lang_dash;?></a></li>
				<li><a href="#"><?php echo $lang_com_set;?></a></li>
			</ul>
		</nav>
	</header>
	<div id="pane-content">
		<div class="widget minimizable g4">
			<header>
				<i class="glyph-settings"></i>
				<h2><?php echo $lang_com_set;?></h2>
			</header>
			<div class="widget-section">
				<div class="content">
					<form action="" method="post" class="js-validate">
					<input type="hidden" name="doFormSave" value="1">
					    <?php 
						if(isset($saved)) { 
							echo "<div class='msg-box closeable success'><strong>¡FELICIDADES!</strong> $lang_save</div>";
						}elseif(isset($error)) {
							echo "<div class='msg-box closeable error'><strong>ERROR:</strong> $lang_error_write</div>";
						} ?>
						<div class="field g2">
							<label><?php echo $lang_com_name;?> :</label>
							<div class="entry">
								<input type="text" class="required" name="com_name" value="<?php echo $com_name; ?>"  />
							</div>
						</div>
						<div class="cf"></div>
						<div class="field g2">
							<label><?php echo $lang_com_address;?> :</label>
							<div class="entry">
								<textarea name="com_addres" class="required"><?php echo $com_addres; ?></textarea>
							</div>
						</div>
						<div class="cf"></div>
						<div class="field g1">
							<label><?php echo $lang_com_telp;?> :</label>
							<div class="entry">
								<input type="text" class="required" value="<?php echo $com_telp; ?>" name="com_telp" />
							</div>
						</div>
						<div class="cf"></div>
						
						<div class="field g2">
							<input type="submit" class="bt red large" value="<?php echo $lang_save_bt;?>" />
						</div>
					</form>
					<div class="cf"></div>
				</div>
			</div>
		</div>
		<div class="cf"></div>
	</div>
</section>