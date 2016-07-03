<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
if(isset($_POST['SavePaket'])) {
	$cek1=mysql_query("SELECT * FROM tbl_paket WHERE nama_paket='$_POST[nama]'");
	if ($cek2=mysql_fetch_array($cek1)){
			$fail = true;
	}else{
        $jenis 		= $_POST['jenis'];
		$nama 		= $_POST['nama'];
		$harga 		= $_POST['harga'];
		$rate 		= $_POST['rate'];
		$limit 		= $_POST['limit'];
		$masaAktiv 	= $_POST['masaAktiv'];

		$API = new routeros_api();
		if ($API->connect($ip_mt,$user_mt,$pass_mt)) {
			$API->write('/ip/hotspot/user/profile/add',false);
			$API->write('=name='.$nama,false);
			$API->write('=rate-limit='.$rate);
			$READ = $API->read(false);
			$API->disconnect();
				
			$query = "INSERT INTO tbl_paket (`jenis`,`nama_paket`,`harga`,`rate`,`masa_aktiv`,`limit`) VALUES('$jenis','$nama','$harga','$rate','$masaAktiv','$limit')";
			if(mysql_query($query)){
				$saved = true;
			}else{
				$error = true;
			}
		}
	}
}

if(isset($_POST['EditPaket'])) {
	$id=$_POST['id'];
    $jenis 		= $_POST['jenis'];
	$nama 		= $_POST['nama'];
	$harga 		= $_POST['harga'];
	$rate 		= $_POST['rate'];
	$limit 		= $_POST['limit'];
	$masaAktiv 	= $_POST['masaAktiv'];
	
	$API = new routeros_api();
	if ($API->connect($ip_mt,$user_mt,$pass_mt)) {
		$API->write('/ip/hotspot/user/profile/print',false);
		$API->write('?name='.$nama,false);
		$API->write('=.proplist=.id');
		$ARRAYS = $API->read();

		$API->write('/ip/hotspot/user/profile/set',false);
		$API->write('=.id='.$ARRAYS[0]['.id'],false);
		$API->write('=name='.$nama,false);
		$API->write('=rate-limit='.$rate);
		$READ = $API->read();
		
		$query = ("UPDATE tbl_paket SET `jenis`='$jenis',`nama_paket`='$nama',`harga`='$harga',`rate`='$rate',`limit`='$limit',`masa_aktiv`='$masaAktiv' WHERE id_paket='$id'");
		if(mysql_query($query)){
			$saved = true;
		}else{
			$error = true;
		}
		
		$API->disconnect();
	}
}

if(!isset($_GET['act'])) $_GET['act']='tampil';
switch($_GET['act']){
	case 'tampil':
	echo "<section id='pane'>
			<header>
				<h1>$lang_packet</h1>
				<nav class='breadcrumbs'>
					<ul>
						<li class='alt'><a href='./'><i class='icon-home'></i></a></li>
						<li><a href='index.php'>$lang_dash</a></li>
						<li><a href='?page=paket'>$lang_packet</a></li>
					</ul>
				</nav>
			</header>
			<div id='pane-content'>
				<div class='widget minimizable g4'>
					<header>
						<h2>$lang_packet</h2>
						<nav class='buttons'>
							<ul>
								<li><a href='#AddPaket' class='modal-trigger'><i class='fugue-plus'></i> $lang_add_pack</a></li>
							</ul>
						</nav>
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
						echo "<table>
								<thead>
									<tr>
										<th>$lang_number</th>
										<th>$lang_name_pack</th>
										<th>$lang_type</th>
										<th>$lang_price_pack</th>
										<th>$lang_rate</th>
										<th>$lang_limit</th>
										<th>$lang_act_time</th>
										<th>$lang_proses</th>
									</tr>
								</thead>
								<tbody>";
								$no=1;
								$q_paket= mysql_query("SELECT * FROM tbl_paket");
								while($r=mysql_fetch_array($q_paket)){
									if($r['jenis'] =='TimeBase'){
										$text = $lang_time;
									}elseif($r['jenis'] =='QuotaBase'){
										$text = 'bytes';
									}else{
										$text = '';
									}
								echo "<tr>
										<td align='center'>$no</td>
										<td>$r[nama_paket]</td>
										<td>$r[jenis]</td>
										<td>$r[harga]</td>
										<td>$r[rate]</td>
										<td>$r[limit] $text</td>
										<td align='center'>$r[masa_aktiv]</td>
										<td align='center'><a href='?page=paket&act=edit&id=$r[id_paket]' class='bt green small'>$lang_edit_bt</a> 
										<a href='?page=paket&act=hapus&id=$r[id_paket]&p=$r[nama_paket]' class='bt red small'>$lang_del_bt</a></td>
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
					<div id='AddPaket' class='window-modal g2' hidden>
						<h2 class='title'>$lang_add_pack</h2>
							<div class='content'>
								<form action='' method='post' class='js-validate'>
								<input type='hidden' name='SavePaket' value='1'>
									<div class='field g2'>
										<label>$lang_type</label>
										<div class='entry'>
											<select class='required' name='jenis'>
												<option value=''>- Seleccione el plan -</option>
												<option value='Unlimited'>Ilimitado</option>
												<option value='TimeBase'>Time Base</option>
												<option value='QuotaBase'>Quota Base</option>
											</select>
										</div>
									</div>
									<div class='cf'></div>
									<div class='field g2'>
										<label>$lang_name_pack ( $lang_nospace )</label>
										<div class='entry'>
											<input type='text' class='required' name='nama' />
										</div>
									</div>
									<div class='cf'></div>
									<div class='field g2'>
										<label>$lang_price_pack</label>
										<div class='entry'>
											<input type='text' class='required' name='harga' />
										</div>
									</div>
									
									<div class='field g2'>
										<label>$lang_rate</label>
										<div class='entry'>
											<input type='text' class='required' name='rate' value='384k/384k' />
										</div>
									</div>
									<div class='cf'></div>
									<div class='field g2'>
										<label>$lang_limit</label>
										<div class='entry'>
											<input type='text' class='required' name='limit' />
											Jika jenis Unlimited isi: Unlimited<br>
											Jika TimeBase isi: jumlah jam<br>
											Jika QuotaBase isi: jumlah bytes
										</div>
									</div>
									
									<div class='field g2'>
										<label>$lang_act_time</label>
										<div class='entry'>
											<input type='text' class='required' name='masaAktiv' />
											Isi jumlah hari
										</div>
									</div>
									<div class='cf'></div>
							</div>
							<footer class='pane'>
								<div class='cf'></div>
								<input type='submit' class='bt green large' value='$lang_save_bt' />
								<a href='#' class='bt red large close'>$lang_cancel_bt</a>
							</footer>
						</form>
					</div>
		</section>";
	break;
	case 'edit':
    $id = $_GET['id'];
    $edit=mysql_query("SELECT * FROM tbl_paket WHERE id_paket='$id'");
    $r=mysql_fetch_array($edit);
		echo "<section id='pane'>
			<header>
				<h1>$lang_packet</h1>
				<nav class='breadcrumbs'>
					<ul>
						<li class='alt'><a href='./'><i class='icon-home'></i></a></li>
						<li><a href='index.php'>$lang_dash</a></li>
						<li><a href='?page=paket'>$lang_packet</a></li>
						<li><a href='#'>$lang_edit_pack</a></li>
					</ul>
				</nav>
			</header>
			<div id='pane-content'>
				<div class='widget minimizable g4'>
					<header>
						<h2>$lang_edit_pack</h2>
					</header>
					<div class='widget-section'>
						<div class='content'>
						<form action='?page=paket' method='post' class='js-validate'>
								<input type='hidden' name='EditPaket' value='1'>
								<input type='hidden' name='id' value='$r[id_paket]'>
									<div class='field g2'>
										<label>$lang_type</label>
										<div class='entry'>
											<select class='required' name='jenis'>";
												if ($r['jenis']=='Unlimited'){
													echo "<option value='Unlimited' selected>Unlimited</option>
													<option value='TimeBase'>Time Base</option>
													<option value='QuotaBase'>Quota Base</option>";
												}elseif ($r['jenis']=='TimeBase'){
													echo "<option value='TimeBase' selected>Time Base</option>
													<option value='Unlimited'>Unlimited</option>
													<option value='QuotaBase'>Quota Base</option>";
												}else{
													echo "<option value='QuotaBase' selected>Quota Base</option>
													<option value='Unlimited'>Unlimited</option>
													<option value='TimeBase'>Time Base</option>";
												}
									echo "</select>
										</div>
									</div>
									<div class='cf'></div>
									<div class='field g2'>
										<label>$lang_name_pack</label>
										<div class='entry'>
											<input type='text' class='required' name='nama' value='$r[nama_paket]' />
										</div>
									</div>
									<div class='cf'></div>
									<div class='field g2'>
										<label>$lang_price_pack</label>
										<div class='entry'>
											<input type='text' class='required' name='harga' value='$r[harga]' />
										</div>
									</div>
									
									<div class='field g2'>
										<label>$lang_rate</label>
										<div class='entry'>
											<input type='text' class='required' name='rate' value='$r[rate]' />
										</div>
									</div>
									<div class='cf'></div>
									<div class='field g2'>
										<label>$lang_limit</label>
										<div class='entry'>
											<input type='text' class='required' name='limit' value='$r[limit]' />
										</div>
									</div>
									
									<div class='field g2'>
										<label>$lang_act_time</label>
										<div class='entry'>
											<input type='text' class='required' name='masaAktiv' value='$r[masa_aktiv]'/>
										</div>
									</div>
									<div class='cf'></div>
							<div class='field g2'>
								<input type='submit' class='bt green large' value='$lang_save_bt' />
								<input type='button' class='bt red large' value='$lang_cancel_bt' onclick=self.history.back() />
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
	//hapus paket
	case 'hapus':	
		$idpaket = $_GET['id'];
		$id = $_GET['p'];
		
		$API = new routeros_api();
		if ($API->connect($ip_mt,$user_mt,$pass_mt)) {
			$API->write('/ip/hotspot/user/profile/print',false);
			$API->write('?name='.$id,false);
			$API->write('=.proplist=.id');
			$ARRAYS = $API->read();

			$API->write('/ip/hotspot/user/profile/remove',false);
			$API->write('=.id=' . $ARRAYS[0]['.id']);
			$READ = $API->read();
			
			mysql_query("DELETE FROM tbl_paket WHERE id_paket='$idpaket'");
			
			$API->disconnect();
		}
		
		echo "<script type='text/javascript'>
					window.location = '?page=paket';
			</script>";
	break;
}
?>