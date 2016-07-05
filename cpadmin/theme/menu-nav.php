<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
?>
<!-- menu #1 -->
<nav>
	<h2><?php echo $lang_menu;?></h2>
	<ul>
		<li><a href="./"><i class="glyph-cloud"></i><div class="label"><?php echo $lang_dash;?></div></a></li>
		<li><a href="?page=billing"><i class="glyph-clock"></i><div class="label"><?php echo $lang_bill;?></div></a></li>
		<li><a href="?page=paket"><i class="glyph-archive"></i><div class="label"><?php echo $lang_packet;?></div></a></li>
		<li><a href="?page=user"><i class="icon-user"></i><div class="label"><?php echo $lang_user;?></div></a></li>
		<li><a href="?page=laporan"><i class="icon-clipboard"></i><div class="label"><?php echo $lang_report;?></div></a></li>
		<li><a href="#"><i class="glyph-settings"></i><div class="label"><?php echo $lang_setting;?></div></a>
			<nav>
				<ul>
					<li><a href="?page=settings"><?php echo $lang_com_set;?></a></li>
					<li><a href="?page=admin"><?php echo $lang_admin;?></a></li>
					<li><a href="?page=mikrotik"><?php echo $lang_mikrotik;?></a></li>
					<li><a href="?page=modul"><?php echo $lang_modul;?></a></li>
				</ul>
			</nav>
		</li>
	</ul>
	<?php 
		$sql=mysql_query("SELECT * FROM tbl_modul WHERE aktif='Y' ORDER by urutan"); 
		$jml = mysql_num_rows($sql);
		if ($jml > 0){
		echo "<h2>$lang_menu_modul</h2>
				<ul>";
			while ($m=mysql_fetch_array($sql)){  
				echo "<li><a href='?page=$m[filename]'><i class='icon-arrow-right-2'></i><div class='label'>Base de datos</div></a></li>";
			}
		echo "</ul>";
		}
	?>
</nav>