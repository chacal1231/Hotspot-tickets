<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/

date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];

$tgl_sekarang = date("Ymd");
$tgl_skrg     = date("d");
$bln_sekarang = date("m");
$bln_kemaren  = date("m")-1;
$thn_sekarang = date("Y");
$jam_sekarang = date("H:i:s");

$nama_bln=array(1=> "Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
//fungsi tanggal indonesia
function tgl_indo($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = getBulan(substr($tgl,5,2));
	$tahun = substr($tgl,0,4);
	return $tanggal.' '.$bulan.' '.$tahun; 
}

function getBulan($bln){
	switch ($bln){
	case 1: 
		return "Enero";
		break;
	case 2:
		return "Febrero";
		break;
	case 3:
		return "Marzo";
		break;
	case 4:
		return "Abril";
		break;
	case 5:
		return "Mayo";
		break;
	case 6:
		return "Junio";
		break;
	case 7:
		return "Julio";
		break;
	case 8:
		return "Agostoto";
		break;
	case 9:
		return "Septiembre";
		break;
	case 10:
		return "Octubre";
		break;
	case 11:
		return "Noviembre";
		break;
	case 12:
		return "Diciembre";
		break;
	}
}

function combotgl($awal, $akhir, $var, $terpilih){
  echo "<div class='field g1'>
			<label>Fecha inicio:</label>
			<div class='entry'>
			<select name='$var'>";
			  for ($i=$awal; $i<=$akhir; $i++){
				$lebar=strlen($i);
				switch($lebar){
				  case 1:
				  {
					$g="0".$i;
					break;     
				  }
				  case 2:
				  {
					$g=$i;
					break;     
				  }      
				}  
				if ($i==$terpilih)
				  echo "<option value='$g' selected>$g</option>";
				else
				  echo "<option value='$g'>$g</option>";
			  }
  echo "</select>
		</div>
	</div> ";
}
function combotgl2($awal, $akhir, $var, $terpilih){
  echo "<div class='field g1'>
			<label>Fecha final:</label>
			<div class='entry'>
			<select name='$var'>";
			  for ($i=$awal; $i<=$akhir; $i++){
				$lebar=strlen($i);
				switch($lebar){
				  case 1:
				  {
					$g="0".$i;
					break;     
				  }
				  case 2:
				  {
					$g=$i;
					break;     
				  }      
				}  
				if ($i==$terpilih)
				  echo "<option value='$g' selected>$g</option>";
				else
				  echo "<option value='$g'>$g</option>";
			  }
  echo "</select>
		</div>
	</div> ";
}
function combobln($awal, $akhir, $var, $terpilih){
  echo "<div class='field g1'>
		<label>Bulan</label>
			<div class='entry'>
			<select name='$var'>";
			  for ($bln=$awal; $bln<=$akhir; $bln++){
				$lebar=strlen($bln);
				switch($lebar){
				  case 1:
				  {
					$b="0".$bln;
					break;     
				  }
				  case 2:
				  {
					$b=$bln;
					break;     
				  }      
				}  
				  if ($bln==$terpilih)
					 echo "<option value='$b' selected>$b</option>";
				  else
					echo "<option value='$b'>$b</option>";
			  }
	  echo "</select>
			</div>
		</div>";
}

function combothn($awal, $akhir, $var, $terpilih){
  echo "<div class='field g1'>
		<label>&nbsp;</label>
			<div class='entry'>
			<select name='$var'>";
		  for ($i=$awal; $i<=$akhir; $i++){
			if ($i==$terpilih)
			  echo "<option value='$i' selected>$i</option>";
			else
			  echo "<option value=$i>$i</option>";
		  }
	  echo "</select>
			</div>
	</div>";
}

function combonamabln($awal, $akhir, $var, $terpilih){
  $nama_bln=array(1=> "Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  echo "<div class='field g2'>
		<label>&nbsp;</label>
			<div class='entry'>
			<select name='$var'>";
			  for ($bln=$awal; $bln<=$akhir; $bln++){
				  if ($bln==$terpilih)
					 echo "<option value='$bln' selected>$nama_bln[$bln]</option>";
				  else
					echo "<option value='$bln'>$nama_bln[$bln]</option>";
			  }
	  echo "</select>
			</div>
		</div> ";
}
//fungsi format rupiah
function format_rupiah($angka){
  $rupiah=number_format($angka,0,',','.');
  return $rupiah;
}
?>
