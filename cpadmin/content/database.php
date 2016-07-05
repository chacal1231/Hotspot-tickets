<?php
/**
* PHP Mikrotik Billing (www.phpmixbill.com)
* Ismail Marzuqi iesien22@yahoo.com
* @version		4.0.0
* @copyright	Copyright (C) 2014 PHP Mikrotik Billing
* @license		GNU General Public License version 2 or later; see LICENSE.txt
* @donate		PayPal: iesien22@yahoo.com / Mandiri: 130.00.1024957.4
**/
?>
					<section id="pane">
						<header>
							<h1><?php echo $lang_Database;?></h1>
							<nav class="breadcrumbs">
								<ul>
									<li class="alt"><a href="/"><i class="icon-home"></i></a></li>
									<li><a href="/index.php"><?php echo $lang_dash;?></a></li>
									<li><a href="#"><?php echo $lang_Database;?></a></li>
								</ul>
							</nav>
						</header>
						<div id="pane-content">
							<div class="widget minimizable g4">
								<header>
									<h2><?php echo $lang_backup_db;?></h2>
								</header>
								<div class="widget-section">
								<div class='content'>
<?php
//membuat nama file
$file	  =	'backup/'.$db_name.'_'.date("DdMY").'_'.time().'.sql';
?>

<script>
function pastikan(text){
	confirm('Apakah Anda yakin akan '+text+'?')
}
</script>

<p><?php echo $lang_info_backup;?></p>


<form action="" method="post" name="postform" enctype="multipart/form-data" >
<div class="field g2">
	<input type="submit" onClick="return pastikan('<?php echo $lang_backup_db;?>')" name="backup" class="bt green large" value="<?php echo $lang_backup_db;?>" />
</div>
<div class="cf"></div>
</form>
<div class="cf"></div>
<br>
<?php
//Download file backup ============================================
if(isset($_GET['nama_file']))
{
	$file = $back_dir.$_GET['nama_file'];
	
	if (file_exists($file))
	{
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: private');
		header('Pragma: private');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
		exit;

	} 
	else 
	{
		echo "<p>File {$_GET['nama_file']} sudah tidak ada.</p>";
	}
	
}

//Backup Database =================================================
if(isset($_POST['backup']))
{
	backup($file);
	echo '<p>Backup Database telah selesai.<br>
	Silahkan <a style="cursor:pointer" href="/billing/'.$file.'" title="Download">Descargar Base de datos</a><br>
	Atau bisa mengambilnya pada folder <strong>backup</strong></p>';
}

?>
									</div>
								</div>
							</div>
							
							<div class="widget minimizable g4">
								<header>
									<h2><?php echo $lang_restore_db;?></h2>
								</header>
								<div class="widget-section">
								<div class='content'>
									<p><?php echo $lang_info_restore;?></p>
									<form action="" method="post" name="postform" enctype="multipart/form-data" >
										<div class="field g2">
											<label><?php echo $lang_file_db;?> <span>(*.sql)</span></label>
											<div class="entry">
												<input type="file" name="datafile" class="custom-file  {fileDefaultText: 'Archivo de Base de datos', fileBtnText: 'click to load'}" /><!-- use options only if you will translate, or edit directly .js -->
											</div>
										</div>
										<div class="cf"></div>
														
										<div class="field g2">
											<input type="submit" onclick="return pastikan('<?php echo $lang_restore_db;?>')"  name="restore" class="bt red large" value="<?php echo $lang_restore_db;?>" />
										</div>
									</form>
								<div class="cf"></div>

<?php

//Restore Database ================================================
if(isset($_POST['restore']))
{
	restore($_FILES['datafile']);
}

function restore($file) {
	global $rest_dir;
	
	$nama_file	= $file['name'];
	$ukrn_file	= $file['size'];
	$tmp_file	= $file['tmp_name'];
	
	if ($nama_file == "")
	{
		echo "<p>Fatal Error</p>";
	}else{
		$alamatfile	= $rest_dir.$nama_file;
		$templine	= array();
		
		if (move_uploaded_file($tmp_file , $alamatfile))
		{
			
			$templine	= '';
			$lines		= file($alamatfile);

			foreach ($lines as $line)
			{
				if (substr($line, 0, 2) == '--' || $line == '')
					continue;
			 
				$templine .= $line;

				if (substr(trim($line), -1, 1) == ';')
				{
					mysql_query($templine) or print('Query gagal \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');

					$templine = '';
				}
			}
			echo "<p>Berhasil Restore Database, silahkan di cek.</p>";
		
		}else{
			echo "<p>Proses upload gagal, kode error = ".$file['error']."</p>";
		}	
	}
	
}

function backup($nama_file,$tables = '')
{
	global $return, $tables, $back_dir, $db_name ;
	
	if($tables == '')
	{
		$tables = array();
		$result = @mysql_list_tables($db_name);
		while($row = @mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}else{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	$return	= '';
	
	foreach($tables as $table)
	{
		$result	 = @mysql_query('SELECT * FROM '.$table);
		$num_fields = @mysql_num_fields($result);
		
		//menyisipkan query drop table untuk nanti hapus table yang lama
		$return	.= "DROP TABLE IF EXISTS ".$table.";";
		$row2	 = @mysql_fetch_row(mysql_query('SHOW CREATE TABLE  '.$table));
		$return	.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = @mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';

				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = @addslashes($row[$j]);
					$row[$j] = @ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	$nama_file;
	
	$handle = fopen($back_dir.$nama_file,'w+');
	fwrite($handle, $return);
	fclose($handle);
}
?>
									</div>
								</div>
							</div>
							<div class="cf"></div>
						</div>
					</section>