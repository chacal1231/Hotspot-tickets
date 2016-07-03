<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
	$mulai=$_POST['thn_mulai']."-".$_POST['bln_mulai']."-".$_POST['tgl_mulai'];
	$selesai=$_POST['thn_selesai']."-".$_POST['bln_selesai']."-".$_POST['tgl_selesai'];
	
	$sql=mysql_query("SELECT * FROM tbl_laporan WHERE daftar BETWEEN '$mulai' AND '$selesai'");
	$jml = mysql_num_rows($sql);
	echo "<section id='pane'>
			<header>
				<h1>Informe diario</h1>
				<nav class='breadcrumbs'>
					<ul>
						<li class='alt'><a href='./'><i class='icon-home'></i></a></li>
						<li><a href='index.php'>Dashboard</a></li>
						<li><a href='?page=laporan'>Laporan</a></li>
						<li><a href='#'>Informe diario</a></li>
					</ul>
				</nav>
			</header>
			<div id='pane-content'>
				<div class='g4'>
					<div class='table-wrapper'>
						<div class='content'>";
	if ($jml > 0){
					echo "<p><a href='#' class='bt red'>PRINT LAPORAN</a> <a href='#' class='bt green'>PDF</a></p><br>
						<table>
								<thead>
									<tr>
										<th>No.</th>
										<th>Username</th>
										<th>Nama Paket</th>
										<th>Harga</th>
										<th>Tgl. Daftar</th>
										<th>Tgl. Expire</th>
										<th>Kasir</th>
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
							echo "<br><p>Total Keseluruhan : <b>Rp. {$tot}</b></p>";
							echo "<p>Jumlah Transaksi : <b>{$jml} transaksi</b></p>";
						}else{
						  $sekarang=date('Y-m-d');
						  echo "<p>Tidak ada transaksi/order pada Tanggal <b>".tgl_indo($sekarang)."</b></p>
							   <div class='entry'><a class='button' onclick='self.history.back()'> << Kembali</a></div>";
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
		window.open('konten/cetak_laporan.php?page=<?php echo $_GET['page'];?>&act=<?php echo $_GET['act'];?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=750,height=600,left=50,top=50,titlebar=yes')
		}
		</script>
	<?php