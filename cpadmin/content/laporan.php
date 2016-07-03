<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
if(!isset($_GET['act'])) $_GET['act']='tampil';
switch($_GET['act']){
  case 'tampil': {  
	echo "<section id='pane'>
		<header>
			<h1>$lang_report</h1>
			<nav class='breadcrumbs'>
				<ul>
					<li class='alt'><a href='./'><i class='icon-home'></i></a></li>
					<li><a href='index.php'>$lang_dash</a></li>
					<li><a href='#'>$lang_report</a></li>
				</ul>
			</nav>
		</header>
		<div id='pane-content'>
			<div class='widget minimizable g4'>
				<header>
					<h2>$lang_report</h2>
				</header>
				<div class='widget-section'>
					<div class='content'>";
					   echo "<form method='POST' action='?page=laporan&act=priode'>
							<div class='space-bottom-10'>
								<a href='?page=laporan&act=harian' class='bt green large'>$lang_day_rep</a>
							</div>";        
							  combotgl(1,31,'tgl_mulai',$tgl_skrg);
							  combonamabln(1,12,'bln_mulai',$bln_kemaren);
							  combothn(2000,$thn_sekarang,'thn_mulai',$thn_sekarang);
							  combotgl2(1,31,'tgl_selesai',$tgl_skrg);
							  combonamabln(1,12,'bln_selesai',$bln_sekarang);
							  combothn(2000,$thn_sekarang,'thn_selesai',$thn_sekarang);
						echo "<div class='cf'></div>
						<div class='space-top-20'><input type='submit' class='bt orange large' value='$lang_priod_rep' />
							</div></form>";
				echo "<div class='cf'></div>
					</div>
				</div>
			</div>
			<div class='cf'></div>
		</div>
	</section>";
	} break;
//harian	
case 'harian':	{
	$sekarang=date('Y-m-d');
    $sql=mysql_query("SELECT * FROM tbl_laporan WHERE daftar='$sekarang'");
	$jml = mysql_num_rows($sql);
	echo "<section id='pane'>
			<header>
				<h1>$lang_day_rep</h1>
				<nav class='breadcrumbs'>
					<ul>
						<li class='alt'><a href='./'><i class='icon-home'></i></a></li>
						<li><a href='index.php'>$lang_dash</a></li>
						<li><a href='?page=laporan'>$lang_report</a></li>
						<li><a href='#'>$lang_day_rep</a></li>
					</ul>
				</nav>
			</header>
			<div id='pane-content'>
				<div class='g4'>
					<div class='table-wrapper'>
						<div class='content'>";
					if ($jml > 0){
					echo "<p><a onClick='popup_print()' class='bt red'>$lang_print_rep</a> <a href='#' class='bt green'>PDF</a></p><br>
						<table>
								<thead>
									<tr>
										<th>$lang_number</th>
										<th>$lang_username</th>
										<th>$lang_name_pack</th>
										<th>$lang_price_pack</th>
										<th>$lang_date_act</th>
										<th>$lang_date_exp</th>
										<th>$lang_casir</th>
									</tr>
								</thead>
								<tbody>";
								$no = 1;
								$total=0;
								while($r = mysql_fetch_array($sql)){
								  
								echo "<tr>
										<td align='center'>$no</td>
										<td>$r[username]</td>
										<td>$r[paket]</td>
										<td>$r[harga]</td>
										<td>".tgl_indo($r['daftar'])." $r[jam]</td>
										<td>".tgl_indo($r['expire'])." $r[jam]</td>
										<td>$r[kasir]</td>
									</tr>";
								$total = $total+$r['harga'];
								$no++;
								}
							echo "</tbody>
							</table>";
							$tot=format_rupiah($total);
							echo "<br><p>$lang_tot_all : <b>Rp. {$tot}</b></p>";
							echo "<p>$lang_tot_trans : <b>{$jml} $lang_trans</b></p>";
						}else{
						  $sekarang=date('Y-m-d');
						  echo "<p>$lang_no_trans <b>".tgl_indo($sekarang)."</b></p>
							   <div class='entry'><a class='button' onclick='self.history.back()'> << $lang_back</a></div>";
						}
						echo "</div>
					</div>
				</div>
				<div class='cf'></div>
			</div>
		</section>";
	?>
<script type="text/javascript">
var s5_taf_parent = window.location;
function popup_print() {
window.open('print.php?page=<?php echo $_GET['act'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=750,height=600,left=50,top=50,titlebar=yes')
}
</script>
	<?php
	}break;
	//priode
case 'priode':
	{
	$mulai=$_POST['thn_mulai']."-".$_POST['bln_mulai']."-".$_POST['tgl_mulai'];
	$selesai=$_POST['thn_selesai']."-".$_POST['bln_selesai']."-".$_POST['tgl_selesai'];
	
	$sql=mysql_query("SELECT * FROM tbl_laporan WHERE daftar BETWEEN '$mulai' AND '$selesai'");
	$jml = mysql_num_rows($sql);
	echo "<section id='pane'>
			<header>
				<h1>$lang_day_rep</h1>
				<nav class='breadcrumbs'>
					<ul>
						<li class='alt'><a href='./'><i class='icon-home'></i></a></li>
						<li><a href='index.php'>$lang_dash</a></li>
						<li><a href='?page=laporan'>$lang_report</a></li>
						<li><a href='#'>$lang_day_rep</a></li>
					</ul>
				</nav>
			</header>
			<div id='pane-content'>
				<div class='g4'>
					<div class='table-wrapper'>
						<div class='content'>";
	if ($jml > 0){
					echo "<p><a onClick='popup_print()' class='bt red'>$lang_print_rep</a> <a href='#' class='bt green'>PDF</a></p><br>
						<table>
								<thead>
									<tr>
										<th>$lang_number</th>
										<th>$lang_username</th>
										<th>$lang_name_pack</th>
										<th>$lang_price_pack</th>
										<th>$lang_date_act</th>
										<th>$lang_date_exp</th>
										<th>$lang_casir</th>
									</tr>
								</thead>
								<tbody>";
								$no = 1;
								$total=0;
								while($r = mysql_fetch_array($sql)){
								  
								echo "<tr>
										<td align='center'>$no</td>
										<td>$r[username]</td>
										<td>$r[paket]</td>
										<td>$r[harga]</td>
										<td>".tgl_indo($r['daftar'])." $r[jam]</td>
										<td>".tgl_indo($r['expire'])." $r[jam]</td>
										<td>$r[kasir]</td>
									</tr>";
								$total = $total+$r['harga'];
								$no++;
								}
							echo "</tbody>
							</table>";
							$tot=format_rupiah($total);
							echo "<br><p>$lang_tot_all : <b>Rp. {$tot}</b></p>";
							echo "<p>$lang_tot_trans : <b>{$jml} $lang_trans</b></p>";
						}else{
						    $m=$_POST['tgl_mulai'].'-'.$_POST['bln_mulai'].'-'.$_POST['thn_mulai'];
							$s=$_POST['tgl_selesai'].'-'.$_POST['bln_selesai'].'-'.$_POST['thn_selesai'];
						  echo "<p>$lang_no_trans <b>$m s/d $s</b></p>
							   <div class='entry'><a class='button' onclick='self.history.back()'> << $lang_back</a></div>";
						}
						echo "</div>
					</div>
				</div>
				<div class='cf'></div>
			</div>
		</section>";
	?>
<script type="text/javascript">
var s5_taf_parent = window.location;
function popup_print() {
window.open('print.php?page=<?php echo $_GET['act'];?>&mulai=<?php echo $_POST['thn_mulai'].'-'.$_POST['bln_mulai'].'-'.$_POST['tgl_mulai'];?>&selesai=<?php echo $_POST['thn_selesai'].'-'.$_POST['bln_selesai'].'-'.$_POST['tgl_selesai'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=750,height=600,left=50,top=50,titlebar=yes')
}
</script>
	<?php
	}break;
}
?>