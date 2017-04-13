<?php
include("menu.php"); 
include("bulan.php");
$kodeorganisasi = $_SESSION["kodeorganisasi"];
?>

<link href="style.css" media="screen, projection" rel="stylesheet" type="text/css"/>
<script src="js/autocomplete.js" type="text/javascript"></script>
<body bgcolor="eee" style="background-color:#eee">
	<div style="border:solid #eee"><font style="color:#eee">XXXX</font></div>
	<form action="lap_honor_per_dosen.php" method="post" name="form">
		<div style="border:solid #eee">	
			<br><br><br>
			<!----------------------------kotak atas-------------------------------------->
			<div class="inset">
				<b class="b1"></b><b class="b2" style="background-color:#800080"></b><b class="b3" style="background-color:#800080"></b><b class="b4" style="background-color:#800080"></b>
				<div class="boxcontent" style="text-align:center;">
			<!---------------------------kotak atas------------------------------------- -->		

					<div style="font:bold 15px verdana; color:#eee; background-color:#800080">
						<div valign="center" align="center" colspan="3" height="22%">
						<h1 style="color:#ddd;">Laporan Honor Pengajar<br></h1>
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
							<input id="namapengajar" style="font:bold 11px verdana;" type="text" name="namapengajar" onkeyup="lihat(this.value)" autocomplete="off"/>
							<input type="text" name="nip" id="nip" readonly="readonly" style="font:bold 11px verdana; color:gray;"/>
							<input type="button" value="clear" onclick="document.getElementById('namapengajar').value = ''; document.getElementById('nip').value = ''; document.getElementById('namapengajar').focus();"/>
					<div id="kotaksugest"></div>
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
									<option value="<?echo date('Y')-2?>"><?echo date('Y')-2?></option>
								</select>
							</span>
							<span>&nbsp;&nbsp;</span>							
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
							<span>&nbsp;&nbsp;</span>
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