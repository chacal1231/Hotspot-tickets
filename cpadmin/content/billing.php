<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
if(isset($_POST['SaveBilling'])) {
	$id = $_POST['id'];
	$paket = $_POST['paket'];
	$aktiv = $_POST['aktiv'];
	$expire = $_POST['expire'];
	$jam = $_POST['jam'];
	
	$query = ("UPDATE tbl_billing SET `id_paket`='$paket',`daftar`='$aktiv',`expire`='$expire',`jam`='$jam' WHERE id_billing='$id'");

	if(mysql_query($query)){
		$saved = true;
	}else{
		$error = true;
	}
}

if(!isset($_GET['act'])) $_GET['act']='tampil';
switch($_GET['act']){
	case 'tampil':
	echo "<section id='pane'>
			<header>
				<h1>$lang_bill</h1>
				<nav class='breadcrumbs'>
					<ul>
						<li class='alt'><a href='./'><i class='icon-home'></i></a></li>
						<li><a href='index.php'>$lang_dash</a></li>
						<li><a href='#'>$lang_bill</a></li>
					</ul>
				</nav>
			</header>
			<div id='pane-content'>
				<div class='widget minimizable g4'>
					<header>
						<h2>$lang_bill</h2>
					</header>
					<div class='table-wrapper'>
						<div class='content'>";
						if(isset($saved)) { 
							echo "<div class='msg-box closeable success'><strong>¡FELICIDADES!</strong> $lang_save</div>";
						}elseif(isset($error)) {
							echo "<div class='msg-box closeable error'><strong>ERROR:</strong> $lang_error</div>";
						}elseif(isset($fail)) {
							echo "<div class='msg-box closeable warning'><strong>ERROR:</strong> $lang_fail</div>";
						}
						echo "<table class='datatable'>
								<thead>
									<tr>
										<th>$lang_number</th>
										<th>$lang_username</th>
										<th>$lang_name_pack</th>
										<th>$lang_date_act</th>
										<th>$lang_date_exp</th>
										<th>Activo</th>
										<th>$lang_proses</th>
									</tr>
								</thead>
								<tbody>";
								$no=1;
								$q_billing = mysql_query("SELECT * FROM tbl_billing,tbl_user WHERE tbl_billing.id_user=tbl_user.id_user ORDER BY id_billing ASC");
								while($r=mysql_fetch_array($q_billing)){
								if($r['status']=='on'){ $icon="<i class='fugue-tick'></i>";}else{ $icon="<i class='fugue-cross'></i>";}
								echo "<tr>
										<td align='center'>$no</td>";
										$q_paket=mysql_query("SELECT nama_paket FROM tbl_paket WHERE id_paket='$r[id_paket]'");
										$p=mysql_fetch_array($q_paket);
								echo "<td>$r[username]</td>
										<td>$p[nama_paket]</td>
										<td>".tgl_indo($r['daftar'])." $r[jam]</td>
										<td>".tgl_indo($r['expire'])." $r[jam]</td>
										<td align='center'>$icon</td>
										<td align='center'><a href='?page=billing&act=edit&id=$r[id_billing]' class='bt green small'>$lang_edit_bt</a></td>
									</tr>";
								$no++;
								}
							echo "</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class='cf'></div>
			</div>
		</section>";
	break;
	//fungsi edit user
	case 'edit':
    $id = $_GET['id'];
	$edit = mysql_query("SELECT * FROM tbl_billing,tbl_user WHERE tbl_billing.id_user=tbl_user.id_user AND tbl_billing.id_billing='$id'");
    $r=mysql_fetch_array($edit);

		echo "<section id='pane'>
			<header>
				<h1>$lang_bill</h1>
				<nav class='breadcrumbs'>
					<ul>
						<li class='alt'><a href='./'><i class='icon-home'></i></a></li>
						<li><a href='index.php'>$lang_dash</a></li>
						<li><a href='?page=billing'>$lang_bill</a></li>
						<li><a href='#'>$lang_edit_bill</a></li>
					</ul>
				</nav>
			</header>
			<div id='pane-content'>
				<div class='widget minimizable g4'>
					<header>
						<h2>$lang_edit_bill</h2>
					</header>
					<div class='widget-section'>
						<div class='content'>
							<form action='?page=billing' method='post' class='js-validate'>
								<input type='hidden' name='SaveBilling' value='1'>
								<input type='hidden' name='id' value='$r[id_billing]'>
									<div class='field g2'>
										<label>$lang_username <span>( $lang_no_edit )</span></label>
										<div class='entry'>
											<input type='text' class='required' name='username' value='$r[username]' readonly />
										</div>
									</div>
									<div class='cf'></div>
									<div class='field g2'>
										<label>$lang_name_pack</label>
										<div class='entry'>
											<select class='required' name='paket'>";
											$paket=mysql_query("SELECT * FROM tbl_paket ORDER BY nama_paket");
											if ($r['id_paket']==0){
												echo "<option value=0 selected>- $lang_get_np -</option>";
											}

											while($p=mysql_fetch_array($paket)){
												if ($r['id_paket']==$p['id_paket']){
													echo "<option value=$p[id_paket] selected>$p[nama_paket]</option>";
												}else{
													echo "<option value=$p[id_paket]>$p[nama_paket]</option>";
												}
											}
									echo "</select>
										</div>
									</div>
									<div class='cf'></div>
									<div class='field g1'>
										<label>$lang_date_act:</label>
										<div class='entry'>
											<input type='text' class='required' name='aktiv' value='$r[daftar]' />
										</div>
									</div>
									<div class='field g1'>
										<label>&nbsp;</label>
										<div class='entry'>
											<input type='text' class='required' value='$r[jam]' readonly />
										</div>
									</div>
									<div class='cf'></div>
									<div class='field g1'>
										<label>$lang_date_exp:</label>
										<div class='entry'>
											<input type='text' class='required' name='expire' value='$r[expire]' />
										</div>
									</div>
									<div class='field g1'>
										<label>&nbsp;</label>
										<div class='entry'>
											<input type='text' class='required' name='jam' value='$r[jam]' />
										</div>
									</div>
									<div class='cf'></div>
							
							<div class='field g2'>
								<input type='submit' class='bt green large' value='$lang_save_bt' />
								<input type='button' class='bt red large' value='$lang_cancel_bt' onclick='self.history.back()' />
							</div>
						</form>
						<div class='cf'></div>
						</div>
					</div>
				</div>
				<div class='cf'></div>
			</div>
			</section>";
	break;
	//fungsi hapus user
	case 'hapus':
		$id = $_GET['id'];

		mysql_query("DELETE FROM tbl_billing WHERE id_billing='$id'");

		echo "<script type='text/javascript'>
					window.location = '?page=billing';
			</script>";
	break;
}
?>