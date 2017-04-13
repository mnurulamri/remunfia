<?php
//if (empty($_SESSION['username'])) header("Location:index.php");
if(!session_id()) session_start();
include("conn.php");
include("menu.php"); 
include("bulan.php");
$kodeorganisasi = $_SESSION["kodeorganisasi"];
$nip = $_SESSION["nip"];
$sql = "SELECT distinct nama_pengajar FROM pengajar WHERE nip = $nip";
$result = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_object($result)){
	$namapengajar = $row->nama_pengajar;
}
?>

<link href="style.css" media="screen, projection" rel="stylesheet" type="text/css"/>
<script src="js/autocomplete.js" type="text/javascript"></script>
<body bgcolor="336666" style="background-color:#336666">
	<div style="border:solid #336666"><font style="color:#336666">XXXX</font></div>
	<form action="lap_honor_per_dosen2.php" method="post" name="form">
		<div style="border:solid #336666">	
			<br><br><br>
			<!----------------------------kotak atas-------------------------------------->
			<div class="inset">
				<b class="b1"></b><b class="b2" style="background-color:#fa0"></b><b class="b3" style="background-color:#fa0"></b><b class="b4" style="background-color:#fa0"></b>
				<div class="boxcontent" style="text-align:center;">
			<!---------------------------kotak atas--------------------------------------->		

					<div style="font:bold 15px verdana; color:#336666; background-color:#fa0">
						<div valign="center" align="center" colspan="3" height="22%">
						<h1>Laporan Honor Pengajar<br></h1>
						</div>
					</div>
				<br>
				
				<div style="font:bold 12px verdana; color:#555">
					<span align="right">
						<label>Nama Pengajar</label>
					</span>
					<span align="center">:
					</span>
					<span>
							<input id="namapengajar" style="font:bold 11px verdana;" type="text" name="namapengajar" value="<?echo $namapengajar?>" readonly="readonly"/>
							<input type="text" name="nip" id="nip" value="<?echo $nip?>" readonly="readonly" style="font:bold 11px verdana; color:gray;"/>
					</span>				
				</div>
				<div>
					<span colspan="3" height="15px"><br></span>
				</div>

				<div style="font:bold 12px verdana; color:#555">
							<span align="right"><label>Tahun</label></span>
							<span align="center">:</span>
							<span>
								<select style="font:bold 11px verdana; color:#555" name="tahun">
									<option value="<?echo date('Y')?>"><?echo date('Y')?></option>
									<option value="<?echo date('Y')-1?>"><?echo date('Y')-1?></option>
								</select>
							</span>
							<span>&nbsp;&nbsp;&nbsp;</span>							
							<span align="right"><label>Bulan</label></span>
							<span align="center"><font color="#555">:</font></span>
							<span>
								<span id="div0">							
									<select style="font:bold 11px verdana; color:#555; width: 10em;" name="bulan_gasal" >
										<option style="color:blue;" value="<?php echo $month ?>"><?php echo $month ?></option>
										<option style="color:magenta;" value="Januari">Januari</option>									
										<option style="color:blue;" value="Februari">Februari</option>
										<option style="color:green;" value="Maret">Maret</option>
										<option style="color:purple;" value="April">April</option>
										<option style="color:red;" value="Mei">Mei</option>
										<option style="color:blue;" value="Juni">Juni</option>
										<option style="color:green;" value="Juli">Juli</option>
										<option style="color:purple;" value="Agustus">Agustus</option>
										<option style="color:red;" value="September">September</option>
										<option style="color:blue;" value="Oktober">Oktober</option>
										<option style="color:green;" value="November">November</option>
										<option style="color:purple;" value="Desember">Desember</option>									
									</select>							
								</span>
							</span>
						</div>
						<div>
							<span>&nbsp;</span>
						</div>					
						<div>
							<hr style="color:#fa0"></hr>
						</div>	
						<div>
							<div align="center">							
								<input type="submit" value="generate" name="generate" style="font:bold 11px verdana; height: 2.5em; :hover" onclick="this.form.target='_blank';return true;"/>
							</div>
						</div>

			<!--------------------------kotak bawah----------------------------------->
				</div>
				<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
			</div>
			<!--------------------------kotak bawah----------------------------------->
		</div>

	</form>

</body>