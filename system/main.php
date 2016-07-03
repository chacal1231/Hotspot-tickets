<?php
	/**
	* PHP Mikrotik Billing (www.phpmixbill.com)
	* Ismail Marzuqi iesien22@yahoo.com
	* @version		4.0.0
	* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
	* @license		GNU General Public License version 2 or later; see LICENSE.txt
	* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
	**/
	ob_start();
	session_start();

	$wordpress_mode = false;

	date_default_timezone_set("Asia/Jakarta");

	// Require login to access admin panel.

	if(!isset($_SESSION['isLoggedIn'])) {
		header("Location: login.php");
		exit("Redirecting to <a href='login.php'>login.php</a>.");
	}

	if(!isset($epath)) {
		$epath = "";
	}
?>