<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
	//include theme header
	require "system/config.php";
	require "system/language.php";
	require "system/api_mikrotik.php";	
	require "system/library.php";

	require "theme/header.php";
	require "system/servermonitor.php";
	
	$page = "home";
	if(isset($_GET['page'])) $page = $_GET['page'];

	if(!file_exists("content/{$page}.php")) {
		$page = "not-found";
	}
	
	//include contents
	require "content/{$page}.php";
	//include theme footer
	require "theme/footer.php";
?>
