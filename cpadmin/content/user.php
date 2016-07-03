<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
if(isset($_POST['SaveUser'])) {
	$cek1=mysql_query("SELECT * FROM tbl_user where username='$_POST[username]'");
	if ($cek2=mysql_fetch_array($cek1)){
			$fail = true;
	}else{
        $nama = $_POST['nama'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$telp = $_POST['telp'];
		
		$query = "INSERT INTO tbl_user (nama_user,username,password,telp) VALUES('$nama','$username','$password','$telp')";
		if(mysql_query($query)){
			$saved = true;
		}else{
			$error = true;
		}
	}
}
if(isset($_POST['EditUser'])) {
	$id=$_POST['id'];
	$nama 		= $_POST['nama'];
	$username 	= $_POST['username'];
	$pass		= $_POST['password'];
	$telp 		= $_POST['telp'];
	
	if($_POST['password'] == "") {
        $query = ("UPDATE tbl_user SET `nama_user`='$nama',`telp`='$telp' WHERE id_user='$id'");
		if(mysql_query($query)){
			$saved = true;
		}else{
			$error = true;
		}
	}else{
        $API = new routeros_api();
		if ($API->connect($ip_mt,$user_mt,$pass_mt)) {
			$API->write('/ip/hotspot/user/print',false);
			$API->write('?name='.$username);
			$API->write('=.proplist=.id');
			$ARRAY1 = $API->read();
			
			$API->write('/ip/hotspot/user/set',false);
			$API->write('=.id='.$ARRAY1[0]['.id'],false);
			$API->write('=password='.$pass);
			$READ = $API->read();
			$query = ("UPDATE tbl_user SET `nama_user`='$nama',`telp`='$telp',`password`='$pass' WHERE id_user='$id'");
			if(mysql_query($query)){
				$saved = true;
			}else{
				$error = true;
			}
			$API->disconnect();
		}
	}
}
if(isset($_POST['BuyPaket'])) {
	$id			= $_POST['id'];
	$pass		= $_POST['password'];
	$paket		= $_POST['paket'];
	$username 	= $_POST['username'];

	$p_query = mysql_query("SELECT * FROM tbl_paket WHERE id_paket='$paket'");
	$p = mysql_fetch_array($p_query);
	
	$jenis_paket = $p['jenis'];
	$nama_paket = $p['nama_paket'];
	$limit = $p['limit'];
	$harga = $p['harga'];
	$masa_aktiv = $p['masa_aktiv'];
	$tgl_exp = date("Ymd", mktime(0,0,0,date("m"),date("d")+$masa_aktiv,date("Y")));
	$kasir = $_SESSION['admin'];
	
	if($jenis_paket=='Unlimited'){
		$API = new routeros_api();
		if ($API->connect($ip_mt,$user_mt,$pass_mt)) {
		//hapus data lama
			$API->write('/ip/hotspot/user/print',false);
			$API->write('?comment='.$username,false);
			$API->write('=.proplist=.id');
			$ARRAYS = $API->read();
			$API->write('/ip/hotspot/user/remove',false);
			$API->write('=.id=' . $ARRAYS[0]['.id']);
			$READ = $API->read();
			mysql_query("DELETE FROM tbl_billing WHERE id_user='$id'");
		//ganti dengan yang baru
			$API->write('/ip/hotspot/user/add',false);
			$API->write('=name='.$username,false);
			$API->write('=profile='.$nama_paket,false);
			$API->write('=comment='.$username,false);
			$API->write('=password='.$pass);
			$READ = $API->read(false);
			$API->disconnect();
		//insert ke table billing
			$query = "INSERT INTO tbl_billing (`jenis`,`jenispaket`,`id_user`,`id_paket`,`daftar`,`expire`,`jam`,`status`,`id_admin`) VALUES('Hotspot','Unlimited','$id','$paket','$tgl_sekarang','$tgl_exp','$jam_sekarang','on','4')";
		//insert ke table laporan
			mysql_query("INSERT INTO tbl_laporan (`username`,`paket`,`harga`,`daftar`,`expire`,`jam`,`jenis`,`kasir`) VALUES('$username','$nama_paket','$harga','$tgl_sekarang','$tgl_exp','$jam_sekarang','Hotspot','$kasir')");
		
			if(mysql_query($query)){
				$saved = true;
			}else{
				$error = true;
			}
		}
	}elseif($jenis_paket=='TimeBase'){
		$API = new routeros_api();
		if ($API->connect($ip_mt,$user_mt,$pass_mt)) {
		//hapus data lama
			$API->write('/ip/hotspot/user/print',false);
			$API->write('?comment='.$username);
			$API->write('=.proplist=.id');
			$ARRAYS = $API->read();
			$API->write('/ip/hotspot/user/remove',false);
			$API->write('=.id=' . $ARRAYS[0]['.id']);
			$READ = $API->read();
			mysql_query("DELETE FROM tbl_billing WHERE id_user='$id'");
		//ganti dengan yang baru
			$API->write('/ip/hotspot/user/add',false);
			$API->write('=name='.$username,false);
			$API->write('=profile='.$nama_paket,false);
			$API->write('=comment='.$username,false);
			$API->write('=limit-uptime='.$limit.':00:00',false);
			$API->write('=password='.$pass);
		    $READ = $API->read(false);
			$API->disconnect();
		//insert ke table billing
			$query = "INSERT INTO tbl_billing (`jenis`,`jenispaket`,`id_user`,`id_paket`,`daftar`,`expire`,`jam`,`status`,`id_admin`) VALUES('Hotspot','TimeBase','$id','$paket','$tgl_sekarang','$tgl_exp','$jam_sekarang','on','4')";
		//insert ke table laporan
			mysql_query("INSERT INTO tbl_laporan (`username`,`paket`,`harga`,`daftar`,`expire`,`jam`,`jenis`,`kasir`) VALUES('$username','$nama_paket','$harga','$tgl_sekarang','$tgl_exp','$jam_sekarang','Hotspot','$kasir')");
		
			if(mysql_query($query)){
				$saved = true;
			}else{
				$error = true;
			}
		}
	}elseif($jenis_paket=='QuotaBase'){
		$API = new routeros_api();
		if ($API->connect($ip_mt,$user_mt,$pass_mt)) {
		//hapus data lama
			$API->write('/ip/hotspot/user/print',false);
			$API->write('?comment='.$username);
			$API->write('=.proplist=.id');
			$ARRAYS = $API->read();
			$API->write('/ip/hotspot/user/remove',false);
			$API->write('=.id=' . $ARRAYS[0]['.id']);
			$READ = $API->read();
			mysql_query("DELETE FROM tbl_billing WHERE id_user='$id'");
		//ganti dengan yang baru
			$API->write('/ip/hotspot/user/add',false);
			$API->write('=name='.$username,false);
			$API->write('=profile='.$nama_paket,false);
			$API->write('=comment='.$username,false);
			$API->write('=limit-bytes-total='.$limit,false);
			$API->write('=password='.$pass);
		    $READ = $API->read(false);
			$API->disconnect();
		//insert ke table billing
			$query = "INSERT INTO tbl_billing (`jenis`,`jenispaket`,`id_user`,`id_paket`,`daftar`,`expire`,`jam`,`status`,`id_admin`) VALUES('Hotspot','QuotaBase','$id','$paket','$tgl_sekarang','$tgl_exp','$jam_sekarang','on','4')";
		//insert ke table laporan
			mysql_query("INSERT INTO tbl_laporan (`username`,`paket`,`harga`,`daftar`,`expire`,`jam`,`jenis`,`kasir`) VALUES('$username','$nama_paket','$harga','$tgl_sekarang','$tgl_exp','$jam_sekarang','Hotspot','$kasir')");
		
			if(mysql_query($query)){
				$saved = true;
			}else{
				$error = true;
			}
		}
	}
	
}

if(!isset($_GET['act'])) $_GET['act']='tampil';
switch($_GET['act']){
	case 'tampil': 
	echo "<section id='pane'>
			<header>
				<h1>$lang_user</h1>
				<nav class='breadcrumbs'>
					<ul>
						<li class='alt'><a href='./'><i class='icon-home'></i></a></li>
						<li><a href='index.php'>$lang_dash</a></li>
						<li><a href='#'>$lang_user</a></li>
					</ul>
				</nav>
			</header>
			<div id='pane-content'>
				<div class='widget minimizable g4'>
					<header>
						<h2>$lang_user</h2>
						<nav class='buttons'>
							<ul>
								<li><a href='#addUser' class='modal-trigger'><i class='fugue-plus'></i> $lang_add_user</a></li>
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
						echo "<table class='datatable'>
								<thead>
									<tr>
										<th>$lang_number</th>
										<th>$lang_full_name</th>
										<th>$lang_username</th>
										<th>$lang_telp</th>
										<th>$lang_buy_packs</th>
										<th>$lang_proses</th>
									</tr>
								</thead>
								<tbody>";
								$no=1;
								$q_user= mysql_query("SELECT * FROM tbl_user");
								while($r=mysql_fetch_array($q_user)){
								echo "<tr>
										<td align='center'>$no</td>
										<td>$r[nama_user]</td>
										<td>$r[username]</td>
										<td>$r[telp]</td>
										<td align='center'><a href='?page=user&act=buy&id=$r[id_user]' class='bt small'>$lang_buy_pack</a></td>
										<td align='center'><a href='?page=user&act=edit&id=$r[id_user]' class='bt green small'>$lang_edit_bt</a> 
										<a href='?page=user&act=hapus&id=$r[id_user]&u=$r[username]' class='bt red small'>$lang_del_bt</a></td>
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
					<div id='addUser' class='window-modal g2' hidden>
						<h2 class='title'>$lang_add_user</h2>
							<div class='content'>
								<form action='' method='post' class='js-validate'>
								<input type='hidden' name='SaveUser' value='1'>
									<div class='field g2'>
										<label>$lang_full_name</label>
										<div class='entry'>
											<input type='text' class='required' name='nama' />
										</div>
									</div>
									<div class='cf'></div>
									<div class='field g2'>
										<label>$lang_username ( $lang_nospace )</label>
										<div class='entry'>
											<input type='text' class='required' name='username' />
										</div>
									</div>
									<div class='cf'></div>
									<div class='field g2'>
										<label>$lang_pass</label>
										<div class='entry'>
											<input type='text' class='required' name='password' />
										</div>
									</div>
									<div class='cf'></div>
									<div class='field g2'>
										<label>$lang_telp</label>
										<div class='entry'>
											<input type='text' class='required' name='telp' />
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
	//fungsi edit user
	case 'edit':	
    $id = $_GET['id'];
    $edit=mysql_query("SELECT * FROM tbl_user WHERE id_user='$id'");
    $r=mysql_fetch_array($edit);

		echo "<section id='pane'>
			<header>
				<h1>$lang_user</h1>
				<nav class='breadcrumbs'>
					<ul>
						<li class='alt'><a href='./'><i class='icon-home'></i></a></li>
						<li><a href='index.php'>$lang_dash</a></li>
						<li><a href='?page=user'>$lang_user</a></li>
						<li><a href='#'>$lang_edit_user</a></li>
					</ul>
				</nav>
			</header>
			<div id='pane-content'>
				<div class='widget minimizable g4'>
					<header>
						<h2>$lang_edit_user</h2>
					</header>
					<div class='widget-section'>
						<div class='content'>
							<form action='?page=user' method='post' class='js-validate'>
								<input type='hidden' name='EditUser' value='1'>
								<input type='hidden' name='id' value='$r[id_user]'>
									<div class='field g2'>
										<label>$lang_full_name</label>
										<div class='entry'>
											<input type='text' class='required' name='nama' value='$r[nama_user]' />
										</div>
									</div>
									<div class='cf'></div>
									<div class='field g2'>
										<label>$lang_username <span>( $lang_no_edit )</span></label>
										<div class='entry'>
											<input type='text' class='required' name='username' value='$r[username]' readonly />
										</div>
									</div>
									<div class='cf'></div>
									<div class='field g2'>
										<label>$lang_pass <span>( lang_leave_pass )</span></label>
										<div class='entry'>
											<input type='text' name='password' value='' />
										</div>
									</div>
									<div class='cf'></div>
									<div class='field g2'>
										<label>$lang_telp</label>
										<div class='entry'>
											<input type='text' class='required' name='telp' value='$r[telp]' />
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
	//fungsi hapus user
	case 'hapus':
		$id = $_GET['id'];
		$username = $_GET['u'];
		$API = new routeros_api();
		if ($API->connect($ip_mt,$user_mt,$pass_mt)) {
			//diskonek user jika sedang aktiv
			$API->write('/ip/hotspot/active/print',false);
			$API->write('?user='.$username);
			$API->write('=.proplist=.id');
			$ARRAY2 = $API->read();
			$API->write('/ip/hotspot/active/remove',false);
			$API->write('=.id='.$ARRAY2[0]['.id']);
			$READ = $API->read();
			//hapus user
			$API->write('/ip/hotspot/user/print',false);
			$API->write('?comment='.$username);
			$API->write('=.proplist=.id');
			$ARRAYS = $API->read();
			$API->write('/ip/hotspot/user/remove',false);
			$API->write('=.id=' . $ARRAYS[0]['.id']);
			$READ = $API->read();
			mysql_query("DELETE FROM tbl_user WHERE id_user='$id'");
			mysql_query("DELETE FROM tbl_billing WHERE id_user='$id'");
			$API->disconnect();
		}
		echo "<script type='text/javascript'>
					window.location = '?page=user';
			</script>";
	break;
	
	case 'buy':
    $id = $_GET['id'];
    $edit=mysql_query("SELECT * FROM tbl_user WHERE id_user='$id'");
    $r=mysql_fetch_array($edit);
		echo "<section id='pane'>
			<header>
				<h1>$lang_user</h1>
				<nav class='breadcrumbs'>
					<ul>
						<li class='alt'><a href='./'><i class='icon-home'></i></a></li>
						<li><a href='index.php'>$lang_dash</a></li>
						<li><a href='?page=user'>$lang_user</a></li>
						<li><a href='#'>$lang_buy_pack</a></li>
					</ul>
				</nav>
			</header>
			<div id='pane-content'>
				<div class='widget minimizable g4'>
					<header>
						<h2>$lang_buy_pack</h2>
					</header>
					<div class='widget-section'>
						<div class='content'>
						<form action='?page=user' method='post' class='js-validate'>
								<input type='hidden' name='BuyPaket' value='1'>
								<input type='hidden' name='id' value='$r[id_user]'>
								<input type='hidden' name='password' value='$r[password]'>
									<div class='field g2'>
										<label>$lang_username</label>
										<div class='entry'>
											<input type='text' class='required' name='username' value='$r[username]' readonly />
										</div>
									</div>
									<div class='cf'></div>
									<div class='field g2'>
										<label>$lang_name_pack</label>
										<div class='entry'>
											<select class='required' name='paket'>
												<option value=''>- Seleccionar paquete -</option>";
												$p_query = mysql_query("SELECT * FROM tbl_paket ORDER BY `id_paket`");
												while($p = mysql_fetch_array($p_query))
												{
													echo "<option value='$p[id_paket]'>$p[nama_paket]</option>";
												}
									echo "</select>
										</div>
									</div>
									<div class='cf'></div>
							<div class='field g2'>
								<input type='submit' class='bt large' value='$lang_buy_pack' />
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
}
?>