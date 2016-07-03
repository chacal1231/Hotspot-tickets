<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
if(isset($_POST['SaveProfile'])) {
	$idUser = $_POST['idUser'];
	$nama = $_POST['nama'];
	$telp = $_POST['telp'];
	$username = $_POST['username'];
	$password = $_POST['password'];

	if($password==""){
		$query = "UPDATE tbl_user SET `username`='$username',`nama_user`='$nama',`telp`='$telp' WHERE id_user='$idUser'";
		if(mysql_query($query)){
			$saved = true;
		}else{
			$error = true;
		}
	} else {
		$q_bill = mysql_query("SELECT * FROM tbl_billing,tbl_user WHERE tbl_billing.id_user=tbl_user.id_user AND tbl_user.username='$username'");
		if ($cek1=mysql_fetch_array($q_bill)){
	        $API = new routeros_api();
			if ($API->connect($ip_mt,$user_mt,$pass_mt)) {
				$API->write('/ip/hotspot/user/print',false);
				$API->write('?name='.$username);
				$API->write('=.proplist=.id');
				$ARRAY1 = $API->read();
				
				$API->write('/ip/hotspot/user/set',false);
				$API->write('=.id='.$ARRAY1[0]['.id'],false);
				$API->write('=password='.$password);
				$READ = $API->read();
				$query = "UPDATE tbl_user SET `username`='$username',`password`='$password',`nama_user`='$nama',`telp`='$telp' WHERE id_user='$idUser'";
				if(mysql_query($query)){
					$saved = true;
				}else{
					$error = true;
				}
				$API->disconnect();
			}
		}else{
			$query = "UPDATE tbl_user SET `username`='$username',`password`='$password',`nama_user`='$nama',`telp`='$telp' WHERE id_user='$idUser'";
			if(mysql_query($query)){
				$saved = true;
			}else{
				$error = true;
			}
		}
	}
}

$id=$_SESSION['username'];
$profil = mysql_query("Select * FROM tbl_user WHERE username='$id'");
$r=mysql_fetch_array($profil);
?>
		<div class="alpha-back">
            <img class="img-responsive img-center" src="theme/images/logo.png">
            <div class="pad-space">
                <form class="form-global" method="post" action="">
                    <h3 class="form-global-heading"><?php echo $lang_my_acc;?></h3>
					<input type="hidden" name="SaveProfile" value="1">
					<input type="hidden" name="idUser" value="<?php echo "$r[id_user]";?>">
                    <input type="text" name="username" id="username" class="form-control" value="<?php echo "$r[username]";?>" readonly>
	                <input type="password" class="form-control" name="password" id="password" placeholder="<?php echo "$lang_pass ($lang_leave_pass)";?>">
	                <input type="text" class="form-control" name="nama" id="nama" value="<?php echo "$r[nama_user]";?>" required>
					<input type="text" class="form-control" name="telp" id="telp" value="<?php echo "$r[telp]";?>" required>
	                <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $lang_save_bt;?></button>
                </form>
				<br />
                  	<p><a class="btn btn-primary btn-lg" role="button" href="index.php"><?php echo $lang_dash;?></a>
					<a class="btn btn-primary btn-lg" role="button" href="logout.php"><?php echo $lang_logout;?></a> </p>
				<?php
				if(isset($saved)) { 
					echo "<br><p class='error-message'><strong>¡FELICIDADES!</strong> $lang_save</p>";
				}elseif(isset($error)) {
					echo "<br><p class='error-message'><strong>ERROR!</strong> $lang_error</p>";
				}
				?>
            </div>
        </div>
