<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
$id_user = $_SESSION['idUser'];
?>
            <div class="alpha-back">
               <img class="img-responsive img-center" src="theme/images/logo.png">
               <br>
               <h3 class="panel-title"><?php echo $lang_welcome;?> <?php echo $_SESSION['nama'];?>, <?php echo $lang_now_logged;?></h3>
               
                  
				<?php 
					$home1=mysql_query("SELECT * FROM tbl_billing,tbl_paket WHERE tbl_billing.id_paket=tbl_paket.id_paket AND tbl_billing.id_user='$id_user'");
					$user=mysql_query("SELECT * FROM tbl_user WHERE id_user='$id_user'");
					$jml = mysql_num_rows($home1);
					
					if ($jml > 0){
						$h = mysql_fetch_array($home1);
						$u = mysql_fetch_array($user);
					echo "<div class='panel-body'><b><?php echo $lang_info_acc;?></b></div>
							<div class='row'>
							<div class='col-xs-5'>
							<p style='text-align:right'>$lang_username:</p>
							<p style='text-align:right'>$lang_name_pack:</p>
							<p style='text-align:right'>$lang_type:</p>
							<p style='text-align:right'>$lang_limit:</p>
							<p style='text-align:right'>$lang_date_act:</p>
							<p style='text-align:right'>$lang_date_exp:</p>
						  </div>";
						echo "<div class='col-xs-7'>
						<p style='text-align:left'><b>$u[username]</b></p>
						<p style='text-align:left'><b>$h[nama_paket]</b></p>
						<p style='text-align:left'><b>$h[jenispaket]</b></p>
						<p style='text-align:left'><b>$h[limit]</b></p>
						<p style='text-align:left'><b>". tgl_indo($h['daftar'])." $h[jam]</b></p>
						<p style='text-align:left'><b><font color='red'>". tgl_indo($h['expire'])." $h[jam]</font></b></p>
						<br></div></div>";
					}else{
						echo "<div class='panel-body'><b>$lang_info_new1</b></div>
						<div class='row'>$lang_info_new2<br><br></div>";
					}
					
				  ?>
               
               <div class="row">
					<p><a class="btn btn-primary btn-lg" role="button" href="?page=profile"><?php echo $lang_account;?></a></p>
					<p>
						<?php 
							$sql=mysql_query("SELECT * FROM tbl_modul WHERE aktif='Y' AND status='user' ORDER by urutan"); 
							$jml = mysql_num_rows($sql);
							if ($jml > 0){
								while ($m=mysql_fetch_array($sql)){  
									echo "<a style='margin:10px 10px 10px 10px' class='btn btn-primary btn-lg' role='button' href='?page=$m[filename]'>$m[nama_modul]</a>";
								}
							}
						?>
						<a style="margin:10px 10px 10px 10px" class="btn btn-primary btn-lg" role="button" href="?page=harga"><?php echo $lang_price_list;?></a>
						<a style="margin:10px 10px 10px 10px" class="btn btn-primary btn-lg" role="button" href="logout.php"><?php echo $lang_logout;?></a>
					</p>
                  </div>
               </div>
			   <br>
            </div>
            <p class="error-message"></p>
            <br><br>