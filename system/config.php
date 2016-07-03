<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
//Pengaturan Database
$db_name = "PHPMixBill4.3";
$db_name = "PHPMixBill4.3";
$db_user = "root";
$db_password = "123456789";
$conn = mysql_connect($db_server,$db_user,$db_password); mysql_select_db($db_name,$conn);

//Pengaturan Mikrotik
$ip_mt = "138.0.88.98";
$user_mt = "whoar";
$pass_mt = "Who@rInternet";

//Pengaturan sistem
$com_name = "PHPMixBill";
$com_addres = "Jl Kubangsari VII No. 31 RT.03/RW.06 Bandung";
$com_telp = "081322225141";
?>