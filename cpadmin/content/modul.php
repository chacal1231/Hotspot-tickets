<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
if(isset($_POST['SaveModul'])) {
	$cek1=mysql_query("SELECT * FROM tbl_modul WHERE nama_modul='$_POST[nama]'");
	if ($cek2=mysql_fetch_array($cek1)){
		$fail = true;
	}else{
		$nama 		= $_POST['nama'];
		$link 		= $_POST['link'];
		$aktif 		= $_POST['aktif'];
		$status 	= $_POST['status'];
		
		$u=mysql_query("SELECT urutan FROM tbl_modul ORDER by urutan DESC");
		$d=mysql_fetch_array($u);
		$urutan=$d['urutan']+1;
		
		$query = "INSERT INTO tbl_modul (nama_modul,filename,status,aktif,urutan) VALUES('$nama','$link','$status','$aktif','$urutan')";
		if(mysql_query($query)){
			$saved = true;
		}else{
			$error = true;
		}
	}
}

if(isset($_POST['EditModul'])) {
	$id			= $_POST['id'];
	$nama 		= $_POST['nama'];
	$link 		= $_POST['link'];
	$publish 	= $_POST['publish'];
	$aktif 		= $_POST['aktif'];
	$status 	= $_POST['status'];

	$query = ("UPDATE tbl_modul SET `nama_modul`='$nama',`filename`='$link',`status`='$status',`aktif`='$aktif' WHERE id_modul='$id'");
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
				<h1>$lang_modul</h1>
				<nav class='breadcrumbs'>
					<ul>
						<li class='alt'><a href='./'><i class='icon-home'></i></a></li>
						<li><a href='index.php'>$lang_dash</a></li>
						<li><a href='?page=paket'>$lang_modul</a></li>
					</ul>
				</nav>
			</header>
			<div id='pane-content'>
				<div class='widget minimizable g4'>
					<header>
						<h2>$lang_modul</h2>
						<nav class='buttons'>
							<ul>
								<li><a href='#AddPaket' class='modal-trigger'><i class='fugue-plus'></i> $lang_add_modul</a></li>
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
						echo "<form method=post action=?page=modul&act=update>
						<table>
								<thead>
									<tr>
										<th>$lang_number</th>
										<th>$lang_name_modul</th>
										<th>$lang_link_modul</th>
										<th>$lang_aktif_modul</th>
										<th>$lang_status_modul</th>
										<th>$lang_modul_order</th>
										<th>$lang_proses</th>
									</tr>
								</thead>
								<tbody>";
								$no=1;
								$q_modul= mysql_query("SELECT * FROM tbl_modul ORDER BY urutan");
								while($r=mysql_fetch_array($q_modul)){
								if($r['aktif']=='Y'){ $icon="<i class='fugue-tick'></i>";}else{ $icon="<i class='fugue-cross'></i>";}
								if($r['status']=='user'){ $hak="Admin & User";}else{ $hak="Admin";}
								echo "<tr>
										<td align='center'>$no</td>
										<td>$r[nama_modul]</td>
										<td>$r[filename]</td>
										<td align='center'>$icon</td>
										<td align='center'>$hak</td>
										<input type=hidden name='id[$no]' value='$r[id_modul]'>
										<td align='center'><input type=text name='jml[$no]' value=$r[urutan] size=1 onchange=\"this.form.submit()\"></td>
										<td align='center'><a href='?page=modul&act=edit&id=$r[id_modul]' class='bt green small'>$lang_edit_bt</a> 
										<a href='?page=modul&act=hapus&id=$r[id_modul]' class='bt red small'>$lang_del_bt</a></td>
									</tr>";
								$no++;
								}
							echo "</tbody>
							</table></form>
						</div>
					</div>
				</div>
				<div class='cf'></div>
			</div>
			<div id='AddPaket' class='window-modal g2' hidden>
				<h2 class='title'>$lang_add_modul</h2>
					<div class='content'>
						<form action='' method='post' class='js-validate'>
						<input type='hidden' name='SaveModul' value='1'>
							<div class='field g2'>
								<label>$lang_name_modul</label>
								<div class='entry'>
									<input type='text' class='required' name='nama' />
								</div>
							</div>
							<div class='cf'></div>

							<div class='field g2'>
								<label>$lang_link_modul</label>
								<div class='entry'>
									<input type='text' class='required' name='link' />
								</div>
							</div>
							<div class='cf'></div>
							<div class='field g1'>
								<label>$lang_aktif_modul</label>
								<div class='entry'>
									<input type=radio name='aktif' value='Y' checked> Y  
									<input type=radio name='aktif' value='N'> N
								</div>
							</div>
							<div class='cf'></div>
							<div class='field g2'>
								<label>$lang_status_modul</label>
								<div class='entry'>
									<input type=radio name='status' value='admin' checked> Hanya Admin 
									<input type=radio name='status' value='user'> User & Admin
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
	//edit
	case 'edit':
    $id = $_GET['id'];
    $edit=mysql_query("SELECT * FROM tbl_modul WHERE id_modul='$id'");
    $r=mysql_fetch_array($edit);
		echo "<section id='pane'>
			<header>
				<h1>$lang_modul</h1>
				<nav class='breadcrumbs'>
					<ul>
						<li class='alt'><a href='./'><i class='icon-home'></i></a></li>
						<li><a href='index.php'>$lang_dash</a></li>
						<li><a href='?page=paket'>$lang_modul</a></li>
						<li><a href='#'>$lang_edit_modul</a></li>
					</ul>
				</nav>
			</header>
			<div id='pane-content'>
				<div class='widget minimizable g4'>
					<header>
						<h2>$lang_edit_modul</h2>
					</header>
					<div class='widget-section'>
						<div class='content'>
						<form action='?page=modul' method='post' class='js-validate'>
								<input type='hidden' name='EditModul' value='1'>
								<input type='hidden' name='id' value='$r[id_modul]'>
									<div class='field g2'>
										<label>$lang_name_modul</label>
										<div class='entry'>
											<input type='text' class='required' name='nama' value='$r[nama_modul]' />
										</div>
									</div>
									<div class='cf'></div>

									<div class='field g2'>
										<label>$lang_link_modul</label>
										<div class='entry'>
											<input type='text' class='required' name='link' value='$r[filename]' />
										</div>
									</div>
									<div class='cf'></div>
									
									<div class='field g1'>
										<label>$lang_aktif_modul</label>
										<div class='entry'>";
										if ($r['aktif']=='Y'){
											echo "<input type=radio name='aktif' value='Y' checked> Y  
												<input type=radio name='aktif' value='N'> N";
										}else{
											echo "<input type=radio name='aktif' value='Y'> Y  
												<input type=radio name='aktif' value='N' checked> N";
										}
										echo "</div>
									</div>
									<div class='cf'></div>
									
									<div class='field g2'>
										<label>$lang_status_modul</label>
										<div class='entry'>";
										if ($r['status']=='user'){
											echo "<input type=radio name='status' value='user' checked> User & Admin  
												<input type=radio name='status' value='admin'> Hanya Admin";
										}else{
											echo "<input type=radio name='status' value='user'> User & Admin  
												<input type=radio name='status' value='admin' checked> Hanya Admin";
										}
								echo "</div>
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
	//hapus
	case 'hapus':	
		$id = $_GET['id'];
		mysql_query("DELETE FROM tbl_modul WHERE id_modul='$id'");

		echo "<script type='text/javascript'>
					window.location = '?page=modul';
			</script>";
	break;
	//update
	case 'update':	
		$id       = $_POST['id'];
		$jml_data = count($id);
		$urutan = $_POST['jml'];
		for ($i=1; $i <= $jml_data; $i++){
			mysql_query("UPDATE tbl_modul SET urutan = '".$urutan[$i]."' WHERE id_modul = '".$id[$i]."'");
			header('Location:index.php?page=modul');
		}
	break;
}
?>