<head>
<script type="text/javascript">
function printpage() {
window.print();  
}
</script>
</head>
 <body topmargin="0" leftmargin="0" onload="printpage()">
 
<?php
include "../system/config.php";
include "../system/library.php";
if ($_GET['page']=='harian'){
$sekarang=date('Y-m-d');
echo "<table width='100%'><tr><td align=center><img src='theme/images/logo.png'></td>
<td align=center><h2>Laporan Penjualan Harian<br>$com_name</h2>$com_addres<br>$com_telp</td></tr></table><hr>";
    echo "<div align=right><b>Tanggal: $sekarang</b></div>
	<table border='1' width='100%' cellspacing='1' cellpading='1'>
			<thead>
			<tr bgcolor='7C6C6C'>
				<th>Nomor</th><th>Username</th><th>Nama Paket</th><th>Tgl. Daftar</th><th>Tgl. Expire</th><th>Janis</th><th>Kasir</th>
			</tr>
			</thead>";
			
   $sql=mysql_query("SELECT * FROM tbl_laporan WHERE daftar='$sekarang'");

$jml = mysql_num_rows($sql);

if ($jml > 0){
$i = 1;
while($r = mysql_fetch_array($sql)){
	echo "<tr>
			<td>$i</td>
			<td>$r[username]</td>
			<td>$r[paket]</td>
			<td>".tgl_indo($r['daftar'])." $r[jam]</td>
			<td>".tgl_indo($r['expire'])." $r[jam]</td>
			<td>$r[jenis]</td>
			<td>$r[kasir]</td>
		</tr>";
		$total = $total+$r[harga];
	  $i++;
	}
	echo "</table>";
	$tot=format_rupiah($total);
	echo "<p>Total Keseluruhan : <b>Rp. {$tot}</b></p>";
	echo "<p>Jumlah Transaksi : <b>{$jml} transaksi</b></p>";
}
else{
  $skrg=date('d-M-Y');
  echo "Tidak ada transaksi/order pada Tanggal <b>$skrg</b><br /><br />
       <input type=button value=Kembali onclick=self.history.back()>";
}
    echo "</table>";

}elseif($_GET['page']=='priode'){
$mulai=$_GET['mulai'];
$selesai=$_GET['selesai'];
echo "<table width='100%'><tr><td align=center><img src='theme/images/logo.png'></td>
<td align=center><h2>Laporan Penjualan Priode<br>$com_name</h2>$com_addres<br>$com_telp</td></tr></table><hr>";
    echo "<div align=right><b>Tanggal Priode: $mulai s/d $selesai</b></div>
          <table border='1' width='100%' cellspacing='1' cellpading='1'>
			<thead>
			<tr bgcolor='7C6C6C'>
				<th>Nomor</th><th>Username</th><th>Nama Paket</th><th>Tgl. Daftar</th><th>Tgl. Expire</th><th>Janis</th><th>Kasir</th>
			</tr>
			</thead>";

// Query untuk merelasikan kedua tabel di filter berdasarkan tanggal
$sql=mysql_query("SELECT * FROM tbl_laporan WHERE daftar BETWEEN '$mulai' AND '$selesai'");
$jml = mysql_num_rows($sql);

if ($jml > 0){
	$i = 1;
	while($r = mysql_fetch_array($sql)){
			echo "<tr>
					<td>$i</td>
					<td>$r[username]</td>
					<td>$r[paket]</td>
					<td>".tgl_indo($r['daftar'])." $r[jam]</td>
					<td>".tgl_indo($r['expire'])." $r[jam]</td>
					<td>$r[jenis]</td>
					<td>$r[kasir]</td>
				</tr>";
			$total = $total+$r[harga];
		  $i++;
		}
			echo "</table>";
			$tot=format_rupiah($total);
			echo "<p>Total Keseluruhan : <b>Rp. {$tot}</b></p>";
			echo "<p>Jumlah Transaksi : <b>{$jml} transaksi</b></p>";
	}else{
	  $m=$_POST['tgl_mulai'].'-'.$_POST['bln_mulai'].'-'.$_POST['thn_mulai'];
	  $s=$_POST['tgl_selesai'].'-'.$_POST['bln_selesai'].'-'.$_POST['thn_selesai'];
	  
	  echo "<p>Tidak ada transaksi/order pada Tanggal <b>$m s/d $s</b></p>
		   <div class='entry'><a class='button' onclick='self.history.back()'> << Kembali</a></div>";
	}

}
?>
</body>