<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
	require "../system/main.php";
	error_reporting(E_ALL); 
	ini_set( 'display_errors','1');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title><?php echo $com_name;?> - Admin Panel</title>
        <meta name="description" content="Billing Hotspot Mikrotik" />
        <meta name="author" content="PHPMixBill.com">

        <!-- Optimized mobile viewport -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- CSS -->
        <link rel="stylesheet" href="theme/css/icomoon.css" />
        <link rel="stylesheet" href="theme/css/websymbols.css" />
        <link rel="stylesheet" href="theme/css/formalize.css" />
        <link rel="stylesheet" href="theme/css/style.css" />
        <link rel="stylesheet" href="theme/css/theme-blue.css" />
        <link rel="stylesheet" href="theme/plugins/ui/ui-custom.css" />
        <link rel="stylesheet" href="theme/plugins/validationEngine/validationEngine.jquery.css" />


        <!-- JAVASCRIPTs -->
        <!--[if lt IE 9]>
            <script language="javascript" type="text/javascript" src="theme/js/html5shiv.js"></script>
        <![endif]-->
        <script src="theme/js/jquery.js"></script>
        <script src="theme/js/browserDetect.js"></script>
        <script src="theme/js/jquery.formalize.min.js"></script>
        <script src="theme/js/less.js"></script>
        <script src="theme/js/jquery.watch.js"></script>
        <script src="theme/js/main.js"></script>
        <script src="theme/js/demo.js"></script>
        <script src="theme/js/respond.min.js"></script>
        <script src="theme/plugins/jquery.uniform.min.js"></script>
        <script src="theme/plugins/jquery.window-modal.js"></script>
        <script src="theme/plugins/ui/ui-custom.js"></script>
        <script src="theme/plugins/ui/multiselect/theme/js/ui.multiselect.js"></script>
        <script src="theme/plugins/ui/ui.spinner.min.js"></script>
        <script src="theme/plugins/datables/jquery.dataTables.min.js"></script>
        <script src="theme/plugins/jquery.metadata.js"></script>
        <script src="theme/plugins/progressbar.js"></script>
        <script src="theme/plugins/jquery.maskedinput-1.3.min.js"></script>
        <script src="theme/plugins/jquery.validate.min.js"></script>
        <script src="theme/plugins/validationEngine/languages/jquery.validationEngine-en.js"></script>
        <script src="theme/plugins/validationEngine/jquery.validationEngine.js"></script>

    </head>
    <body class="fixed fixed-topbar"><!-- .fixed or .fluid -->
		<div id="wrapper">
			<section id="top">
				<header>
					<nav id="menu-bar">
						<ul>
							<li class="with-submenu">
								<a href="#"><?php echo $lang_welcome;?> <?php echo $_SESSION['admin'];?></a>
								<nav class="submenu">
									<ul>
										<li><a href="?page=admin"><?php echo $lang_edit_profile;?></a></li>
									</ul>
								</nav>
							</li>
							<!-- .keep makes the element aways visible (even in smaller screens) -->
							<li class="keep"><a href="logout.php" class="bold"><?php echo $lang_logout;?></a></li>
						</ul>
					</nav>
				</header>
			</section>
			<section id="page">
				<aside id="sidebar">
					<div id="logo">
						<a href="index.php"><img src="theme/images/logo.png" alt="PHPMixBill" /></a>
					</div>
					<div class="menus">
					<?php include "menu-nav.php";?>
					</div>
				</aside>
				<section id="content">
					<section id="content-top"><br></section>
					<div class="cf"></div>