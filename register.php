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
if(isset($_POST['register'])) {

	$cek1=mysql_query("SELECT * FROM tbl_user where username='$_POST[username]'");
	if ($cek2=mysql_fetch_array($cek1)){
			$fail = true;
	}else{
        $nama = $_POST['nama'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$telp = $_POST['telp'];
		
		$query = "INSERT INTO tbl_user (nama_user,username,password,telp) VALUES('$nama','$username','$password','$telp')";
		if(mysql_query($query)){
			$saved = true;
		}else{
			$error = true;
		}
	}

}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?php echo $lang_register;?></title>
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
               
               <div class="pad-space">
                  <form class="form-global" method="post" action="">
                     <h3 class="form-global-heading"><?php echo $lang_info_reg;?></h3>
					 <input type="hidden" name="register" value="1">
                     <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo $lang_username;?>" required autofocus>
	                 <input type="password" class="form-control" name="password" id="password" placeholder="<?php echo $lang_pass;?>" required>
	                 <input type="password" class="form-control" name="passwordconf" id="passwordconf" placeholder="Confirm password" required>
					 <input type="text" class="form-control" name="nama" id="nama" placeholder="<?php echo $lang_full_name;?>" required>
					 <input type="text" class="form-control" name="telp" id="telp" placeholder="<?php echo $lang_telp;?>" required>
	                 <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $lang_register;?></button>
                  </form>
				  <br />
                  <p><a class="btn btn-primary btn-lg" role="button" href="login.php"><?php echo $lang_login;?></a> <a class="btn btn-primary btn-lg" role="button" href="contact.php"><?php echo $lang_contact;?></a></a> </p>
				  
				<?php
					if(isset($saved)) { 
						echo "<br><p class='error-message'><strong>¡FELICIDADES!</strong> $lang_reg_save</p>";
					}elseif(isset($error)) {
						echo "<br><p class='error-message'><strong>ERROR!</strong> $lang_reg_error</p>";
					}elseif(isset($fail)) {
						echo "<br><p class='error-message'><strong>FAIL!</strong> $lang_reg_fail</p>";
					}
				?>
               </div>
            </div>
         </div>
      </div>
      <script src="js/jquery.js"></script>
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>