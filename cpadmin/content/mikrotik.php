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

	$ip_mt 		= '';
	$user_mt 	= '';
	$pass_mt 	= '';
	
	if(isset($_POST['ip_mt']))
		$ip_mt = $_POST['ip_mt'];
	if(isset($_POST['user_mt']))
		$user_mt = $_POST['user_mt'];
	if(isset($_POST['pass_mt']))
		$pass_mt = $_POST['pass_mt'];
		
	if(!empty($ip_mt) && !empty($user_mt))
	{
		if(!is_writable('../system/config.php'))
			$error = true;
			
		if(empty($error))
		{
			# menulis konfigurasi
			$conf = file_get_contents('../system/config.php');
			$conf = preg_replace("/ip_mt.*;/i", 'ip_mt = "'.$ip_mt.'";', $conf);
			$conf = preg_replace("/user_mt.*;/i", 'user_mt = "'.$user_mt.'";', $conf);
			$conf = preg_replace("/pass_mt.*;/i", 'pass_mt = "'.$pass_mt.'";', $conf);
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
		<h1><?php echo $lang_mikrotik;?></h1>
		<nav class="breadcrumbs">
			<ul>
				<li class="alt"><a href="./"><i class="icon-home"></i></a></li>
				<li><a href="/index.php"><?php echo $lang_dash;?></a></li>
				<li><a href="#"><?php echo $lang_mikrotik;?></a></li>
			</ul>
		</nav>
	</header>
	<div id="pane-content">
		<div class="widget minimizable g4">
			<header>
				<i class="glyph-settings"></i>
				<h2><?php echo $lang_mikrotik;?></h2>
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
						<div class="field g1">
							<label><?php echo $lang_ip_mt;?></label>
							<div class="entry">
								<input type="text" class="required" name="ip_mt" value="<?php echo "$ip_mt"; ?>" />
							</div>
						</div>
						<div class="cf"></div>
						<div class="field g1">
							<label><?php echo $lang_user_mt;?></label>
							<div class="entry">
								<input type="text" class="required" name="user_mt" value="<?php echo $user_mt; ?>" />
							</div>
						</div>
						<div class="cf"></div>
						<div class="field g1">
							<label><?php echo $lang_pass_mt;?></label>
							<div class="entry">
								<input type="text" class="required" name="pass_mt" value="<?php echo $pass_mt; ?>" />
							</div>
						</div>
						<div class="cf"></div>
						<div class="field g1">
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