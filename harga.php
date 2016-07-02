<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
require "system/config.php";
require "system/language.php";
require "system/library.php";

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
<div class="container-global">
	<div class="alpha80" style="-moz-border-radius:10px; border-radius:10px; ">
		<img class="img-responsive img-center" src="theme/images/logo.png">
		<h3 class="form-global-heading"><?php echo $lang_info_price;?></h3>
        <br>
    </div>
	<br>

	<button id="btn1" class="btn btn-lg btn-default btn-block">PRICE PLANS UNLIMITED</button>
	<p></p>
	<div id="first_form" class="alpha80" style="-moz-border-radius:10px; border-radius:10px; display: none;">
		<div class="pad-space">
				<?php
				$q_paket= mysql_query("SELECT * FROM tbl_paket WHERE jenis='Unlimited'");
				while($r=mysql_fetch_array($q_paket)){
				if($r['jenis'] =='TimeBase'){
					$text = 'Jam';
				}elseif($r['jenis'] =='QuotaBase'){
					$text = 'bytes';
				}else{
					$text = '';
				}
				echo"<p><h3>$r[nama_paket]</h3>
				<div class='btn-group-vertical' data-toggle='buttons'>
					<label class='btn btn-sm btn-default btn-block' style='text-align:center; color:#C04343;font-weight:bold;font-size:32px;'>Rp. ". format_rupiah($r['harga'])."</label>
					<label class='btn btn-sm btn-default btn-block' style='text-align:left; padding-left:10px;'>$lang_rate : $r[rate]</label>
					<label class='btn btn-sm btn-default btn-block' style='text-align:left; padding-left:10px;'>$lang_limit : $r[limit] $text</label>
					<label class='btn btn-sm btn-default btn-block' style='text-align:left; padding-left:10px;'>$lang_act_time : $r[masa_aktiv] $lang_day</label>
				</div></p>";
				}?>
			<br />
        </div>
    </div>
    <br>

    <button id="btn2" class="btn btn-lg btn-default btn-block">PRICE PLANS TIMEBASE</button>
    <p></p>
    <div id="second_form" class="alpha80" style="-moz-border-radius:10px; border-radius:10px; display: none;">
		<div class="pad-space">
			
				<?php
				$q_paket= mysql_query("SELECT * FROM tbl_paket WHERE jenis='TimeBase'");
				while($r=mysql_fetch_array($q_paket)){
				if($r['jenis'] =='TimeBase'){
					$text = 'Jam';
				}elseif($r['jenis'] =='QuotaBase'){
					$text = 'bytes';
				}else{
					$text = '';
				}
				echo"<p><h3>$r[nama_paket]</h3>
				<div class='btn-group-vertical' data-toggle='buttons'>
					<label class='btn btn-sm btn-default btn-block' style='text-align:center; color:#C04343;font-weight:bold;font-size:32px;'>Rp. ". format_rupiah($r['harga'])."</label>
					<label class='btn btn-sm btn-default btn-block' style='text-align:left; padding-left:10px;'>$lang_rate : $r[rate]</label>
					<label class='btn btn-sm btn-default btn-block' style='text-align:left; padding-left:10px;'>$lang_limit : $r[limit] $text</label>
					<label class='btn btn-sm btn-default btn-block' style='text-align:left; padding-left:10px;'>$lang_act_time : $r[masa_aktiv] $lang_day</label>
				</div></p>";
				}?>
			<br />
        </div>
    </div>
    <br>
	
    <button id="btn3" class="btn btn-lg btn-default btn-block">PRICE PLANS QUOTABASE</button>
    <p></p>
    <div id="third_form" class="alpha80" style="-moz-border-radius:10px; border-radius:10px; display: none;">
		<div class="pad-space">
				<?php
				$q_paket= mysql_query("SELECT * FROM tbl_paket WHERE jenis='QuotaBase'");
				while($r=mysql_fetch_array($q_paket)){
				if($r['jenis'] =='TimeBase'){
					$text = 'Jam';
				}elseif($r['jenis'] =='QuotaBase'){
					$text = 'bytes';
				}else{
					$text = '';
				}
				echo"<p><h3>$r[nama_paket]</h3>
				<div class='btn-group-vertical' data-toggle='buttons'>
					<label class='btn btn-sm btn-default btn-block' style='text-align:center; color:#C04343;font-weight:bold;font-size:32px;'>Rp. ". format_rupiah($r['harga'])."</label>
					<label class='btn btn-sm btn-default btn-block' style='text-align:left; padding-left:10px;'>$lang_rate : $r[rate]</label>
					<label class='btn btn-sm btn-default btn-block' style='text-align:left; padding-left:10px;'>$lang_limit : $r[limit] $text</label>
					<label class='btn btn-sm btn-default btn-block' style='text-align:left; padding-left:10px;'>$lang_act_time : $r[masa_aktiv] $lang_day</label>
				</div></p>";
				}?>
			<br />
        </div>
    </div>
    <br>
	<p><a class="btn btn-primary btn-lg" role="button" href="index.php"><?php echo $lang_login;?></a>
	<a class="btn btn-primary btn-lg" role="button" href="contact.php"><?php echo $lang_contact;?></a> </p>
 </div>

<?php 
	require "theme/footer.php";
?>