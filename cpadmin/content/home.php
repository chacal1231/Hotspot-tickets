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
							<h1><?php echo $lang_dash;?></h1>
							<nav class="breadcrumbs">
								<ul>
									<li class="alt"><a href="/"><i class="icon-home"></i></a></li>
									<li><a href="#"><?php echo $lang_dash;?></a></li>
								</ul>
							</nav>
						</header>
						<div id="pane-content">
							<div class="widget minimizable g2">
								<header>
									<i class="glyph-user"></i>
									<h2><?php echo $lang_stat;?></h2>
								</header>
								<div class="table-wrapper">
									<div class="content">
										<table>
											<?php 
											$all_hotspot=mysql_query("SELECT * FROM tbl_billing");
											$t1 = mysql_num_rows($all_hotspot);
											$on_hotspot=mysql_query("SELECT * FROM tbl_billing WHERE status='on'");
											$t2 = mysql_num_rows($on_hotspot);
											$off_hotspot=mysql_query("SELECT * FROM tbl_billing WHERE status='off'");
											$t3 = mysql_num_rows($off_hotspot);
											?>
											<tr>
												<td><?php echo $lang_tot_user;?></td>
												<td align="center"><?php echo $t1;?></td>
											</tr>
											<tr>
												<td><?php echo $lang_user_act;?></td>
												<td align="center"><?php echo $t2;?></td>
											</tr>
											<tr>
												<td><?php echo $lang_user_exp;?></td>
												<td align="center"><?php echo $t3;?></td>
											</tr>
									</table>
									</div>
								</div>
							</div>
							
							<div class="widget minimizable g2">
								<header>
									<i class="glyph-terminal"></i>
									<h2><?php echo $lang_stat_serv;?></h2>
								</header>
								<div class="table-wrapper">
									<div class="content">
										<table>
										<?php
											$Monitor = new ServerMonitor();
											$Monitor->add("Internet", "google.com", 80);
											$Monitor->add("Router", "$ip_mt", 80);
											$Monitor->add("MySQL Server", "127.0.0.1", 3306);
											$results = $Monitor->run();
										foreach($results as $result){	
											$status = $result->active ? "<font color='green'>Conectado</font>" : "<font color='red'>Desconectado</font>";
											echo '<tr><td>Conexión - '.$result->name . '</td><td align=center>' . $status . '</td></tr>';
										}
										?>
										</table>
									</div>
								</div>
							</div>
							<div class="widget minimizable g4">
								<header>
									<h2><?php echo $lang_exp_day;?></h2>
								</header>
								<div class="table-wrapper">
								<div class='content'>
									<table>
										<thead>
											<tr>
												<th><?php echo $lang_number;?></th>
												<th><?php echo $lang_username;?></th>
												<th><?php echo $lang_name_pack;?></th>
												<th><?php echo $lang_date_act;?></th>
												<th><?php echo $lang_date_exp;?></th>
											</tr>
										</thead>
										<tbody>
										<?php
										$sekarang=date('Y-m-d');
										//tampilkan data expire hari ini
										$show = mysql_query("SELECT * FROM tbl_billing,tbl_user WHERE tbl_billing.id_user=tbl_user.id_user AND tbl_billing.expire='$sekarang' ORDER BY id_billing ASC") or die(mysql_error());
										$no = 1;
										while($exp = mysql_fetch_array($show))
										{
											echo "<tr>
													<td>$no</td>";
													$paket=mysql_query("SELECT nama_paket FROM tbl_paket WHERE id_paket='$exp[id_paket]'");
													$p=mysql_fetch_array($paket);
											echo "<td>".$exp['nama_user']."</td>
													<td>".$p['nama_paket']."</td>
													<td align='center'><b>".tgl_indo($exp['daftar'])."-".$exp['jam']."</b></td>
													<td align='center'><b><font color='red'>".tgl_indo($exp['expire'])."-".$exp['jam']."</font></b></td>
													</tr>";
												$no++;
										}
										?>
										</tbody>
									</table>
								</div>
								</div>
							</div>
							<div class="cf"></div>
						</div>
					</section>