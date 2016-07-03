<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
if(isset($_POST['SaveAdmin'])) {
	$idAdmin = $_POST['idAdmin'];
	$nama = $_POST['nama'];
	$username = $_POST['username'];
	$password=$_POST['password'];
	$level = "Admin";
	if($password==""){
		$query = "UPDATE tbl_admin SET `username`='$username',`nama_admin`='$nama' WHERE id_admin='$idAdmin'";
		if(mysql_query($query)){
			$saved = true;
		}else{
			$error = true;
		}
	} else {
		$query = "UPDATE tbl_admin SET `username`='$username',`password`='".md5($password)."',`nama_admin`='$nama' WHERE id_admin='$idAdmin'";
		if(mysql_query($query)){
			$saved = true;
		}else{
			$error = true;
		}
	}
}

$id=$_SESSION['username'];
$profil = mysql_query("Select * FROM tbl_admin WHERE username='$id'");
$r=mysql_fetch_array($profil);
?>
<section id="pane">
	<header>
		<h1><?php echo $lang_admin;?></h1>
		<nav class="breadcrumbs">
			<ul>
				<li class="alt"><a href="./"><i class="icon-home"></i></a></li>
				<li><a href="index.php"><?php echo $lang_dash;?></a></li>
				<li><a href="#"><?php echo $lang_admin;?></a></li>
			</ul>
		</nav>
	</header>
	<div id="pane-content">
		<div class="widget minimizable g4">
			<header>
				<i class="glyph-settings"></i>
				<h2><?php echo $lang_admin;?></h2>
			</header>
			<div class="widget-section">
				<div class="content">
					<form action="" method="post" class="js-validate">
					<input type="hidden" name="SaveAdmin" value="1">
					<input type="hidden" name="idAdmin" value="<?php echo "$r[id_admin]";?>">
					    <?php 
						if(isset($saved)) { 
							echo "<div class='msg-box closeable success'><strong>¡FELICIDADES!</strong> $lang_save</div>";
						}elseif(isset($error)) {
							echo "<div class='msg-box closeable error'><strong>ERROR:</strong> $lang_error</div>";
						} ?>
						<div class="field g2">
							<label><?php echo $lang_username;?></label>
							<div class="entry">
								<input type="text" class="required" name="username" value="<?php echo "$r[username]";?>" />
							</div>
						</div>
						<div class="cf"></div>
						
						<div class="field g2">
							<label><?php echo $lang_pass;?> <span>( <?php echo $lang_leave_pass;?> )</span></label>
							<div class="entry">
								<input type="text" name="password" />
							</div>
						</div>
						<div class="cf"></div>
						<div class="field g2">
							<label><?php echo $lang_full_name;?></label>
							<div class="entry">
								<input type="text" class="required" name="nama" value="<?php echo "$r[nama_admin]";?>" />
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