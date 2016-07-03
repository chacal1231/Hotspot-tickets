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
	
	if(isset($_SESSION['isLoggedIn'])) {
		header("Location: index.php");
		exit("Redirecting to <a href='./index.php'>./index.php</a>.");
	}
	require "../system/config.php";
	$username = $_POST['username'];
	
	$login=mysql_query("SELECT * FROM tbl_admin WHERE username='$username'");
    $r=mysql_fetch_array($login);
	   
    if(isset($_POST['username'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        
        if($username == $r['username']) {
            if($password == $r['password']) {
                $_SESSION['isLoggedIn'] = true;
				$_SESSION['id'] = $r['id_admin'];
				$_SESSION['admin'] = $r['nama_admin'];
				$_SESSION['username'] = $r['username'];
                header("Location: index.php");
                exit;
            }
        }else{
			$error = true;
		}
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Login Admin Panel</title>
        <meta name="description" content="Billing Hotspot Mikrotik" />
        <meta name="author" content="PHPMixBill">
        <meta name="keywords" content="mighty admin, admin, themeforest, panel, administrator, theme, template, html template" />

        <!-- Optimized mobile viewport -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- CSS -->
        <link rel="stylesheet" href="theme/css/icomoon.css" />
        <link rel="stylesheet" href="theme/css/websymbols.css" />
        <link rel="stylesheet" href="theme/css/formalize.css" />
        <link rel="stylesheet" href="theme/css/style.css" />
        <link rel="stylesheet" href="theme/css/theme-blue.css" />
        <link rel="stylesheet" href="theme/plugins/chosen/chosen.css" />
        <link rel="stylesheet" href="theme/plugins/ui/ui-custom.css" />
        <link rel="stylesheet" href="theme/plugins/tipsy/tipsy.css" />
        <link rel="stylesheet" href="theme/plugins/validationEngine/validationEngine.jquery.css" />
        <link rel="stylesheet" href="theme/plugins/elrte/theme/css/elrte.min.css" />
        <link rel="stylesheet" href="theme/plugins/miniColors/jquery.miniColors.css" />
        <link rel="stylesheet" href="theme/plugins/fullCalendar/fullcalendar.css" />
        <link rel="stylesheet" href="theme/plugins/elfinder/theme/css/elfinder.css" />
        <link rel="stylesheet" href="theme/plugins/farbtastic/farbtastic.css" />

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
        <script src="theme/plugins/prefixfree.min.js"></script>
        <script src="theme/plugins/jquery.uniform.min.js"></script>
        <script src="theme/plugins/jquery.window-modal.js"></script>
        <script src="theme/plugins/chosen/chosen.jquery.min.js"></script>
        <script src="theme/plugins/ui/ui-custom.js"></script>
        <script src="theme/plugins/ui/multiselect/theme/js/ui.multiselect.js"></script>
        <script src="theme/plugins/ui/ui.spinner.min.js"></script>
        <script src="theme/plugins/datables/jquery.dataTables.min.js"></script>
        <script src="theme/plugins/jquery.metadata.js"></script>
        <script src="theme/plugins/progressbar.js"></script>
        <script src="theme/plugins/feedback.js"></script>
        <script src="theme/plugins/farbtastic/farbtastic.js"></script>
        <script src="theme/plugins/tipsy/jquery.tipsy.js"></script>
        <script src="theme/plugins/jquery.maskedinput-1.3.min.js"></script>
        <script src="theme/plugins/jquery.validate.min.js"></script>
        <script src="theme/plugins/validationEngine/languages/jquery.validationEngine-en.js"></script>
        <script src="theme/plugins/validationEngine/jquery.validationEngine.js"></script>
        <script src="theme/plugins/jquery.elastic.js"></script>
        <script src="theme/plugins/elrte/elrte.min.js"></script>
        <script src="theme/plugins/miniColors/jquery.miniColors.min.js"></script>
        <script src="theme/plugins/fullCalendar/fullcalendar.min.js"></script>
        <script src="theme/plugins/elfinder/elfinder.min.js"></script>
    </head>
    <body class="fixed fixed-topbar"><!-- .fixed or .fluid -->
		<div class="single">
			<div id="logo">
				<img src="theme/images/logo.png" alt="logo" />
			</div>
			<section id="content">
				<div class="box">
					<form action="" method="post" class="validate-engine">
						<label>
							<i class="fugue-user"></i>
							<input type="text" name="username" data-validation-engine="validate[required]" id="login" placeholder="Login" autofocus />
						</label>
						<span class="divider"></span>
						<label>
							<i class="fugue-lock"></i>
							<input type="password" name="password" data-validation-engine="validate[required]" id="pass" placeholder="Password" />
						</label>
						
						<input type="submit" class="bt large full-bt" value="Login" />
					</form>
				</div>
				<footer>
					<a href="">PHP Mikrotik Billing</a>
				</footer>
			</section>
		</div>
	</body>
</html>