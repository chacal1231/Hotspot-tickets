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
include "system/config.php";
require "system/api_mikrotik.php";
include "system/library.php";

$query_exp = mysql_query("SELECT * FROM tbl_billing WHERE `status`='on'");
while ($r=mysql_fetch_array($query_exp)){
	$todays_date = strtotime(date("Y-m-d H:i:s"));
	$end_date = strtotime("$r[expire] $r[jam]");
	//ambil data user
	$user=mysql_query("SELECT * FROM tbl_user WHERE id_user='$r[id_user]'");
	$u=mysql_fetch_array($user);
	$nama = $u['username'];
	
	if ($todays_date >= $end_date){
		//disable
		$API = new routeros_api();
		if ($API->connect($ip_mt,$user_mt,$pass_mt)) {
			$API->write('/ip/hotspot/user/print',false);
			$API->write('?name='.$nama);
			$API->write('=.proplist=.id');
			$ARRAY1 = $API->read();

			$API->write('/ip/hotspot/active/print',false);
			$API->write('?user='.$nama);
			$API->write('=.proplist=.id');
			$ARRAY2 = $API->read();
			
			$API->write('/ip/hotspot/user/set',false);
			$API->write('=.id='.$ARRAY1[0]['.id'],false);
			//isi dengan 5 detik agar ada keterangan akun telah expire
			$API->write('=limit-uptime=00:00:05');
			
			$API->write('/ip/hotspot/active/remove',false);
			$API->write('=.id='.$ARRAY2[0]['.id']);
			
			$READ = $API->read();
			
			mysql_query("UPDATE tbl_billing SET `status`='off' WHERE id_billing='$r[id_billing]'");
			
			$API->disconnect();
		}
	}
}
?>