<?php 
include("menu.php"); 
include("bulan.php");
?>
<script>
	var cur = 0;
	function displayDiv(idx) {
		if (cur==idx) return true;
		document.getElementById("div"+cur).style.display = "none";
		document.getElementById("div"+idx).style.display = "block";
		cur = idx;
		return true;
	}
		
	window.onload = function() {
		return displayDiv(document.form.semester.selectedIndex);
	}
</script>

<link href="style.css" media="screen, projection" rel="stylesheet" type="text/css">

<body bgcolor="#eee" style="background-color:#eee">
<div style="border:solid #eee; height:70px"><font style="color:#eee">&nbsp;</font></div>
	<form action="lap_honor_per_matakuliah.php" method="post" name="form">
		<div style="border:solid #eee">	
		
			<!----------------------------kotak atas-------------------------------------->
			<div class="inset">
				<b class="b1"></b><b class="b2" style="background-color:#800080"></b><b class="b3" style="background-color:#800080"></b><b class="b4" style="background-color:#800080"></b>
				<div class="boxcontent" style="text-align:center;">
			<!---------------------------kotak atas------------------------------------- -->		

					<div style="font:bold 15px verdana; color:#eee; background-color:#800080">
						<div valign="center" align="center" colspan="3" height="22%">
						<h1 style="color:#ddd;">Laporan Honor Mata Kuliah<br>Per Bulan</h1>
						</div>
					</div>
					<table align="center" style="text:align:center">
						<tr>
							<td colspan="3" height="23px"></td>
						</tr>
						
						<!--====================================================================================-->	
						<? if ($_SESSION["username"] == "admin" or $_SESSION["username"] == "remunerasifisipui"){?>							
						
						<tr style="margin-left:30%; font:bold 12px verdana; color:#555">
							<td align="right"><label>Progam Studi</label></td>
							<td align="center">&nbsp;:&nbsp;</td>
							<td>
								<select style="font:bold 11px verdana; color:#555" name="kode_prodi">
									<option value="02.01.09.01">S1 Reguler Ilmu Komunikasi</option>
									<option value="01.02.09.01">S1 Reguler Ilmu Politik</option>
									<option value="05.03.09.01">S1 Reguler Ilmu Administrasi Fiskal</option>
									<option value="06.03.09.01">S1 Reguler Ilmu Administrasi Negara</option>
									<option value="07.03.09.01">S1 Reguler Ilmu Administrasi Niaga</option>
									<option value="01.04.09.01">S1 Reguler Sosiologi</option>
									<option value="01.05.09.01">S1 Reguler Kriminologi</option>
									<option value="01.06.09.01">S1 Reguler Ilmu Kesejahteraan Sosial</option>
									<option value="02.07.09.01">S1 Reguler Antropologi Sosial</option>
									<option value="01.08.09.01">S1 Reguler Ilmu Hubungan Internasional</option>
									<option value="06.01.09.01">S1 Paralel Ilmu Komunikasi</option>
									<option value="05.02.09.01">S1 Paralel Ilmu Politik</option>
									<option value="13.03.09.01">S1 Paralel Ilmu Administrasi Fiskal</option>
									<option value="14.03.09.01">S1 Paralel Ilmu Administrasi Negara</option>
									<option value="15.03.09.01">S1 Paralel Ilmu Administrasi Niaga</option>
									<option value="05.05.09.01">S1 Paralel Kriminologi</option>
									<option value="07.01.09.01">S1 Kls Internasional Ilmu Komunikasi</option>
									<option value="03.01.09.01">S1 Ekstensi Ilmu Komunikasi - Ekstensi</option>
									<option value="02.02.09.01">S1 Ekstensi Ilmu Politik - Ekstensi</option>
									<option value="08.03.09.01">S1 Ekstensi Ilmu Administrasi Fiskal - Ekstensi</option>
									<option value="09.03.09.01">S1 Ekstensi Ilmu Administrasi Negara - Ekstensi</option>
									<option value="10.03.09.01">S1 Ekstensi Ilmu Administrasi Niaga - Ekstensi</option>
									<option value="02.05.09.01">S1 Ekstensi Kriminologi - Ekstensi</option>
									<option value="04.01.09.01">S2 Ilmu Komunikasi</option>
									<option value="03.02.09.01">S2 Ilmu Politik</option>
									<option value="11.03.09.01">S2 Ilmu Administrasi</option>
									<option value="02.04.09.01">S2 Sosiologi</option>
									<option value="03.05.09.01">S2 Kriminologi</option>
									<option value="02.06.09.01">S2 Ilmu Kesejahteraan Sosial</option>
									<option value="03.07.09.01">S2 Antropologi</option>
									<option value="02.08.09.01">S2 Ilmu Hub Internasional</option>
									<option value="03.08.09.01">S2 Kajian Terorisme & Keamanan Internasional</option>
									<option value="05.01.09.01">S3 Ilmu Komunikasi</option>
									<option value="04.02.09.01">S3 Ilmu Politik</option>
									<option value="12.03.09.01">S3 Ilmu Administrasi</option>
									<option value="03.04.09.01">S3 Sosiologi</option>
									<option value="04.05.09.01">S3 Kriminologi</option>
									<option value="03.06.09.01">S3 Ilmu Kesejahteraan Sosial</option>
									<option value="04.07.09.01">S3 Antropologi</option>
								</select>
							</td>
						</tr>
						<?}?>
						<!--====================================================================================-->	
					</table>	
					
					<div>
						<div colspan="3" height="15px"></div>
					</div>
					<div style="font:bold 12px verdana; color:#555">
						<span align="right"><label>Tahun</label></span>
						<span align="center">:</span>
						<span>
							<select style="font:bold 11px verdana; color:#555" name="tahun">
								<option value="<?echo date('Y')?>"><?echo date('Y')?></option>
								<option value="<?echo date('Y')-1?>"><?echo date('Y')-1?></option>
								<option value="<?echo date('Y')-2?>"><?echo date('Y')-2?></option>
								<option value="<?echo date('Y')-3?>"><?echo date('Y')-3?></option>
							</select>
						</span>
						<span>&nbsp;&nbsp;&nbsp;</span>							
						<span align="right"><label>Bulan</label></span>
						<span align="center"><font color="#555">:</font></span>
						<span>
							<span id="div0">							
								<select style="font:bold 11px verdana; color:#555; width: 10em;" name="bulan" >
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
							<input type="submit" value="generate" name="generate" style="font:bold 11px verdana; height: 2.5em; :hover"/>
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