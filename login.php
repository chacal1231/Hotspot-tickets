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
	require "system/config.php";
	require "system/language.php";
	$username = $_POST['username'];

	$login=mysql_query("SELECT * FROM tbl_user WHERE username='$username'");
    $r=mysql_fetch_array($login);

    if(isset($_POST['username'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if($username == $r['username']) {
            if($password == $r['password']) {
                $_SESSION['isLoggedIn'] = true;
				$_SESSION['nama'] = $r['nama_user'];
				$_SESSION['username'] = $r['username'];
				$_SESSION['idUser'] = $r['id_user'];
                header("Location: index.php");
                exit;
            }
        }else{
			$error = true;
		}
    }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?php echo $com_name;?> - Member Panel</title>
      <link href="theme/css/bootstrap.css" rel="stylesheet">
      <link href="theme/css/style.css" rel="stylesheet">
      
      <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="theme/js/html5shiv.js"></script>
      <script src="theme/js/respond.min.js"></script>
      <![endif]-->
   </head>
   <body class="body-background" >
      <div class="container">
         <div class="container-global">
            <div class="alpha-back">
               <form class="form-global" method="post" action="">
                  <img class="img-responsive img-center" src="theme/images/logo.png">
                  <div class="pad-space">
                  <h3 class="form-global-heading"><?php echo $lang_info_login;?></a></h3>
                  <br>
                  <p><input type="text" name="username" id="userlogin" class="form-control" placeholder="<?php echo $lang_username;?>" required autofocus></p>
                  <p><input type="password" class="form-control" name="password" id="userpass" placeholder="<?php echo $lang_pass;?>" required></p>
                  <button class="btn btn-lg btn-primary btn-block" type="submit" id="login"><?php echo $lang_login;?></a></button>
               </form>
               <br />
               <p><a class="btn btn-primary btn-lg" role="button" href="register.php"><?php echo $lang_register;?></a> 
			   <a class="btn btn-primary btn-lg" role="button" href="harga.php"><?php echo $lang_price_list;?></a>
			   <a class="btn btn-primary btn-lg" role="button" href="contact.php"><?php echo $lang_contact;?></a> </p>
             </div>
            </div>
         </div>
      </div>
      <script src="theme/js/jquery.js"></script>
      <script src="theme/js/bootstrap.min.js"></script>
   </body>
</html>