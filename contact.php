<?php
	/**
	* PHP Mikrotik Billing (www.phpmixbill.com)
	* Ismail Marzuqi iesien22@yahoo.com
	* @version		4.0.0
	* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
	* @license		GNU General Public License version 2 or later; see LICENSE.txt
	* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
	**/
include "system/config.php";
require "system/language.php";
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?php echo $lang_contact;?></title>
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
               <img class="img-responsive img-center" src="theme/images/logo.png">
               
               <br>
               <div style="padding:20px;">
                  <p><?php echo $lang_info_contact;?></p>
                  <p><?php echo $com_name; ?></p>
                  <p><?php echo $com_addres; ?></p>
				  <p><?php echo $com_telp; ?></p>
               </div>
               <br />
               <p><a class="btn btn-primary btn-lg" role="button" href="login.php"><?php echo $lang_login;?></a> 
			   <a class="btn btn-primary btn-lg" role="button" href="register.php"><?php echo $lang_register;?></a> </p>
			   <br />
            </div>
         </div>
      </div>
      <script src="js/jquery.js"></script>
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>